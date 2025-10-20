<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageOptimizationService
{
    protected $defaultSizes = [
        'xs' => 400,
        'sm' => 600,
        'md' => 800,
        'lg' => 1200,
        'xl' => 1920
    ];

    /**
     * Process a single uploaded image
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param array $sizes
     * @param int $quality
     * @return array
     */
    public function processImage(UploadedFile $file, string $directory = 'images', array $sizes = [], int $quality = 85): array
    {
        if (empty($sizes)) {
            $sizes = array_keys($this->defaultSizes);
        }

        $originalPath = $file->store($directory, 'public');
        $imageSizes = [];

        // Build base filename from stored original to keep variants consistent
        $pathInfo = pathinfo($originalPath);
        $baseFilename = $this->sanitizeBaseFilename($pathInfo['filename']);

        foreach ($sizes as $size) {
            $width = $this->defaultSizes[$size] ?? 800;
            $optimizedPath = $this->createOptimizedImageFromPath(
                Storage::disk('public')->path($originalPath),
                $directory,
                $baseFilename,
                $size,
                $width,
                $quality
            );
            
            if ($optimizedPath) {
                $imageSizes[$size] = [
                    'path' => $optimizedPath,
                    'width' => $width,
                    'url' => asset('storage/' . $optimizedPath)
                ];
            }
        }

        return [
            'original' => $originalPath,
            'sizes' => $imageSizes
        ];
    }

    /**
     * Process multiple uploaded images
     *
     * @param array $files
     * @param string $directory
     * @param array $sizes
     * @param int $quality
     * @return array
     */
    public function processMultipleImages(array $files, string $directory = 'images', array $sizes = [], int $quality = 85): array
    {
        $results = [];
        
        foreach ($files as $file) {
            $results[] = $this->processImage($file, $directory, $sizes, $quality);
        }
        
        return $results;
    }

    /**
     * Process an image that is already stored on disk (public disk path relative, e.g. "gallery/foo.jpg").
     * Generates WEBP responsive variants based on the stored original file.
     *
     * @param string $storedRelativePath Relative path on the public disk
     * @param string $directory Target directory for variants
     * @param array $sizes Size keys to generate
     * @param int $quality WEBP quality
     * @return array{original:string,sizes:array}
     */
    public function processStoredImage(string $storedRelativePath, string $directory = 'images', array $sizes = [], int $quality = 85): array
    {
        if (empty($sizes)) {
            $sizes = array_keys($this->defaultSizes);
        }

        $fullOriginalPath = Storage::disk('public')->path($storedRelativePath);
        $pathInfo = pathinfo($storedRelativePath);
        $baseFilename = $this->sanitizeBaseFilename($pathInfo['filename'] ?? 'image');

        $imageSizes = [];
        foreach ($sizes as $size) {
            $width = $this->defaultSizes[$size] ?? 800;
            $optimizedPath = $this->createOptimizedImageFromPath(
                $fullOriginalPath,
                $directory,
                $baseFilename,
                $size,
                $width,
                $quality
            );
            if ($optimizedPath) {
                $imageSizes[$size] = [
                    'path' => $optimizedPath,
                    'width' => $width,
                    'url' => asset('storage/' . $optimizedPath),
                ];
            }
        }

        return [
            'original' => $storedRelativePath,
            'sizes' => $imageSizes,
        ];
    }

    /**
     * Create responsive images
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $quality
     * @return array
     */
    public function createResponsiveImages(UploadedFile $file, string $directory = 'images', int $quality = 85): array
    {
        return $this->processImage($file, $directory, array_keys($this->defaultSizes), $quality);
    }

    /**
     * Get optimized image URL
     *
     * @param string $basePath
     * @param string $size
     * @return string|null
     */
    public function getOptimizedImageUrl(string $basePath, string $size = 'medium'): ?string
    {
        $optimizedPath = $this->getOptimizedPath($basePath, $size);
        
        if ($optimizedPath && Storage::disk('public')->exists($optimizedPath)) {
            return asset('storage/' . $optimizedPath);
        }
        
        return null;
    }

    /**
     * Create optimized image
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string $size
     * @param int $width
     * @param int $quality
     * @return string|null
     */
    protected function createOptimizedImage(UploadedFile $file, string $directory, string $size, int $width, int $quality): ?string
    {
        try {
            // Intervention Image v3 API
            $image = Image::read($file->getRealPath());
            // Downscale by width only to preserve aspect ratio (no upscaling)
            $originalWidth = $image->width();
            if ($originalWidth > 0 && $originalWidth > $width) {
                $image->scaleDown(width: $width);
            }

            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $optimizedFilename = $filename . '_' . $size . '.webp';
            $optimizedPath = $directory . '/' . $optimizedFilename;

            $image->save(storage_path('app/public/' . $optimizedPath), quality: $quality);

            return $optimizedPath;
        } catch (\Exception $e) {
            \Log::error('Image optimization failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create optimized image from an existing stored file path.
     */
    protected function createOptimizedImageFromPath(string $originalFullPath, string $directory, string $baseFilename, string $size, int $width, int $quality): ?string
    {
        try {
            $image = Image::read($originalFullPath);
            $originalWidth = $image->width();
            if ($originalWidth > 0 && $originalWidth > $width) {
                $image->scaleDown(width: $width);
            }

            $optimizedFilename = $baseFilename . '_' . $size . '.webp';
            $optimizedPath = $directory . '/' . $optimizedFilename;
            $image->save(storage_path('app/public/' . $optimizedPath), quality: $quality);
            return $optimizedPath;
        } catch (\Exception $e) {
            \Log::error('Image optimization (from path) failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get optimized path for size
     *
     * @param string $basePath
     * @param string $size
     * @return string|null
     */
    protected function getOptimizedPath(string $basePath, string $size): ?string
    {
        $pathInfo = pathinfo($basePath);
        // Always target generated .webp variants
        $optimizedPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_' . $size . '.webp';
        
        return $optimizedPath;
    }

    /**
     * Remove any trailing size suffixes like _xs/_sm/_md/_lg/_xl (possibly duplicated)
     * from a filename before appending our new size suffix.
     */
    protected function sanitizeBaseFilename(string $filename): string
    {
        // Remove repeated size suffix patterns at the end
        $pattern = '/(_(xs|sm|md|lg|xl))+$/i';
        return preg_replace($pattern, '', $filename) ?? $filename;
    }
}