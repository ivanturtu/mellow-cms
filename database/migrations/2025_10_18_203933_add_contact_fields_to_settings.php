<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add contact fields to settings if they don't exist
        $settings = [
            ['key' => 'contact_address', 'value' => 'Via Roma 123, 00100 Roma, Italia', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+39 06 1234567', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'info@hotelmellow.com', 'type' => 'email', 'group' => 'general'],
            ['key' => 'map_latitude', 'value' => '41.9028', 'type' => 'text', 'group' => 'general'],
            ['key' => 'map_longitude', 'value' => '12.4922', 'type' => 'text', 'group' => 'general'],
            ['key' => 'map_zoom', 'value' => '15', 'type' => 'number', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \App\Models\Setting::whereIn('key', [
            'contact_address', 'contact_phone', 'contact_email', 
            'map_latitude', 'map_longitude', 'map_zoom'
        ])->delete();
    }
};