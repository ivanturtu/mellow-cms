<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group'
    ];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $type = 'text', $group = 'general')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group]
        );
    }

    public static function getGroup($group)
    {
        return static::where('group', $group)->pluck('value', 'key');
    }

    public static function getGroupedSettings()
    {
        $settings = static::all()->groupBy('group');
        $grouped = [];
        
        foreach ($settings as $group => $items) {
            $grouped[$group] = $items->pluck('value', 'key')->toArray();
        }
        
        return $grouped;
    }
}
