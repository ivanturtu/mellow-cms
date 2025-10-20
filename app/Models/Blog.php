<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\HandlesImageOptimization;

class Blog extends Model
{
    use HandlesImageOptimization;
    
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'image',
        'image_sizes',
        'category',
        'slug',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'image_sizes' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
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
