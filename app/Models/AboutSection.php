<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'cta_text',
        'cta_link',
        'image_1',
        'image_1_sizes',
        'image_2', 
        'image_2_sizes',
        'image_3',
        'image_3_sizes',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'image_1_sizes' => 'array',
        'image_2_sizes' => 'array',
        'image_3_sizes' => 'array'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    /**
     * Get optimized image URL for specific size
     *
     * @param string $imageField
     * @param string $size
     * @return string
     */
    public function getOptimizedImageUrl(string $imageField, string $size = 'md'): string
    {
        $sizesField = $imageField . '_sizes';
        
        if ($this->$sizesField && isset($this->$sizesField[$size])) {
            return asset('storage/' . $this->$sizesField[$size]['path']);
        }
        
        // Fallback to original image
        return asset('storage/' . $this->$imageField);
    }

    /**
     * Get responsive image srcset
     *
     * @param string $imageField
     * @return string
     */
    public function getResponsiveSrcset(string $imageField): string
    {
        $sizesField = $imageField . '_sizes';
        
        if (!$this->$sizesField) {
            return '';
        }

        $srcset = [];
        $sizes = ['xs', 'sm', 'md', 'lg', 'xl'];
        $widths = ['xs' => 400, 'sm' => 600, 'md' => 800, 'lg' => 1200, 'xl' => 1920];

        foreach ($sizes as $size) {
            if (isset($this->$sizesField[$size])) {
                $url = asset('storage/' . $this->$sizesField[$size]['path']);
                $width = $widths[$size];
                $srcset[] = $url . ' ' . $width . 'w';
            }
        }

        return implode(', ', $srcset);
    }
}
