<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'image_sizes',
        'category',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'image_sizes' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get optimized image URL for specific size
     *
     * @param string $size
     * @return string
     */
    public function getOptimizedImageUrl(string $size = 'md'): string
    {
        if ($this->image_sizes && isset($this->image_sizes[$size])) {
            return asset('storage/' . $this->image_sizes[$size]['path']);
        }

        // Try derived WEBP variant from original filename (e.g., image_md.webp)
        if (!empty($this->image)) {
            $info = pathinfo($this->image);
            $derivedPath = ($info['dirname'] !== '.' ? $info['dirname'] . '/' : '') . $info['filename'] . '_' . $size . '.webp';
            if (Storage::disk('public')->exists($derivedPath)) {
                return asset('storage/' . $derivedPath);
            }
        }

        // Fallback to original uploaded image
        return asset('storage/' . $this->image);
    }

    /**
     * Get responsive image srcset
     *
     * @return string
     */
    public function getResponsiveSrcset(): string
    {
        if (!$this->image_sizes) {
            return '';
        }

        $srcset = [];
        $sizes = ['xs', 'sm', 'md', 'lg', 'xl'];
        $widths = ['xs' => 400, 'sm' => 600, 'md' => 800, 'lg' => 1200, 'xl' => 1920];

        foreach ($sizes as $size) {
            if (isset($this->image_sizes[$size])) {
                $url = asset('storage/' . $this->image_sizes[$size]['path']);
                $width = $widths[$size];
                $srcset[] = $url . ' ' . $width . 'w';
            }
        }

        return implode(', ', $srcset);
    }
}
