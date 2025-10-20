<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HandlesImageOptimization;

class Slider extends Model
{
    use HandlesImageOptimization;
    
    protected $fillable = [
        'title',
        'description',
        'image',
        'image_sizes',
        'cta_text',
        'cta_link',
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
        // Handle case where image_sizes is still a JSON string
        $imageSizes = $this->image_sizes;
        if (is_string($imageSizes)) {
            $imageSizes = json_decode($imageSizes, true);
        }
        
        if ($imageSizes && isset($imageSizes[$size])) {
            return asset('storage/' . $imageSizes[$size]['path']);
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
        // Handle case where image_sizes is still a JSON string
        $imageSizes = $this->image_sizes;
        if (is_string($imageSizes)) {
            $imageSizes = json_decode($imageSizes, true);
        }
        
        if (!$imageSizes) {
            return '';
        }

        $srcset = [];
        $sizes = ['xs', 'sm', 'md', 'lg', 'xl'];
        $widths = ['xs' => 400, 'sm' => 600, 'md' => 800, 'lg' => 1200, 'xl' => 1920];

        foreach ($sizes as $size) {
            if (isset($imageSizes[$size])) {
                $url = asset('storage/' . $imageSizes[$size]['path']);
                $width = $widths[$size];
                $srcset[] = $url . ' ' . $width . 'w';
            }
        }

        return implode(', ', $srcset);
    }
}
