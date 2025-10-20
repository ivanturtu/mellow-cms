<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Room extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'image_sizes',
        'price',
        'price_per_night',
        'size',
        'capacity',
        'bed_type',
        'bed_count',
        'bath_count',
        'person_count',
        'wifi',
        'air_conditioning',
        'tv_cable',
        'services',
        'features',
        'amenities',
        'location_address',
        'location_city',
        'location_state',
        'location_zip',
        'location_country',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'price_per_night' => 'decimal:2',
        'wifi' => 'boolean',
        'air_conditioning' => 'boolean',
        'tv_cable' => 'boolean',
        'features' => 'array',
        'amenities' => 'array',
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

    public function getServicesArrayAttribute()
    {
        return $this->services ? explode(',', $this->services) : [];
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function activeImages()
    {
        return $this->hasMany(RoomImage::class)->active()->ordered();
    }

    public function primaryImage()
    {
        return $this->hasOne(RoomImage::class)->where('is_primary', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            if (empty($room->slug)) {
                $room->slug = Str::slug($room->name);
            }
        });

        static::updating(function ($room) {
            if ($room->isDirty('name') && empty($room->slug)) {
                $room->slug = Str::slug($room->name);
            }
        });
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
        
        // Fallback to original image stored on public disk
        return asset('storage/' . ltrim($this->image, '/'));
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
