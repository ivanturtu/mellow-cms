<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::getGroupedSettings();
        
        // Use custom robots.txt if provided
        if (!empty($settings['seo']['robots_txt'])) {
            $robots = $settings['seo']['robots_txt'];
        } else {
            $robots = "User-agent: *\n";
            $robots .= "Allow: /\n";
            $robots .= "Disallow: /admin/\n";
            $robots .= "Disallow: /storage/\n";
            $robots .= "Disallow: /vendor/\n";
            $robots .= "Disallow: /bootstrap/\n";
            $robots .= "Disallow: /database/\n";
            $robots .= "Disallow: /tests/\n";
            $robots .= "Disallow: /node_modules/\n";
            $robots .= "\n";
            $robots .= "Sitemap: " . url('/sitemap.xml') . "\n";
        }
        
        return response($robots, 200, [
            'Content-Type' => 'text/plain'
        ]);
    }
}
