<?php

namespace App\Traits;

use App\Services\ImageOptimizationService;
use Illuminate\Http\UploadedFile;

trait HandlesImageOptimization
{
    protected $imageOptimizationService;

    /**
     * Initialize the image optimization service
     */
    protected function initializeImageOptimization()
    {
        if (!$this->imageOptimizationService) {
            $this->imageOptimizationService = new ImageOptimizationService();
        }
    }

    /**
     * Process a single uploaded image
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param array $sizes
     * @param int $quality
     * @return array
     */
    protected function processImage(UploadedFile $file, string $directory = 'images', array $sizes = [], int $quality = 85): array
    {
        $this->initializeImageOptimization();
        return $this->imageOptimizationService->processImage($file, $directory, $sizes, $quality);
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
    protected function processMultipleImages(array $files, string $directory = 'images', array $sizes = [], int $quality = 85): array
    {
        $this->initializeImageOptimization();
        return $this->imageOptimizationService->processMultipleImages($files, $directory, $sizes, $quality);
    }

    /**
     * Create responsive images
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $quality
     * @return array
     */
    protected function createResponsiveImages(UploadedFile $file, string $directory = 'images', int $quality = 85): array
    {
        $this->initializeImageOptimization();
        return $this->imageOptimizationService->createResponsiveImages($file, $directory, $quality);
    }

    /**
     * Get optimized image URL
     *
     * @param string $basePath
     * @param string $size
     * @return string|null
     */
    protected function getOptimizedImageUrl(string $basePath, string $size = 'medium'): ?string
    {
        $this->initializeImageOptimization();
        return $this->imageOptimizationService->getOptimizedImageUrl($basePath, $size);
    }

    /**
     * Get responsive image srcset
     *
     * @param string $basePath
     * @param array $sizes
     * @return string
     */
    protected function getResponsiveSrcset(string $basePath, array $sizes = ['xs', 'sm', 'md', 'lg', 'xl']): string
    {
        $srcset = [];
        
        foreach ($sizes as $size) {
            $url = $this->getOptimizedImageUrl($basePath, $size);
            if ($url) {
                $width = $this->getSizeWidth($size);
                $srcset[] = $url . ' ' . $width . 'w';
            }
        }
        
        return implode(', ', $srcset);
    }

    /**
     * Process an already stored image to generate WEBP responsive variants.
     *
     * @param string $storedRelativePath
     * @param string $directory
     * @param array $sizes
     * @param int $quality
     * @return array
     */
    protected function processStoredImage(string $storedRelativePath, string $directory = 'images', array $sizes = [], int $quality = 85): array
    {
        $this->initializeImageOptimization();
        return $this->imageOptimizationService->processStoredImage($storedRelativePath, $directory, $sizes, $quality);
    }

    /**
     * Get width for size name
     *
     * @param string $size
     * @return int
     */
    private function getSizeWidth(string $size): int
    {
        $widths = [
            'xs' => 400,
            'sm' => 600,
            'md' => 800,
            'lg' => 1200,
            'xl' => 1920
        ];
        
        return $widths[$size] ?? 800;
    }
}
