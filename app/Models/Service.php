<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'icon',
        'image',
        'image_sizes',
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
        
        // Fallback to original image
        return asset($this->image);
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
