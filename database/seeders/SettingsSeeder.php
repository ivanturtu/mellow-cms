<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        // Create or update logo setting
        Setting::updateOrCreate(
            ['key' => 'logo', 'group' => 'general'],
            [
                'value' => 'mellow/images/main-logo.png',
                'type' => 'text'
            ]
        );
    }
}