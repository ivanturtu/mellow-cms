<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Homepage
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . url('/') . '</loc>';
        $sitemap .= '<lastmod>' . now()->format('Y-m-d') . '</lastmod>';
        $sitemap .= '<changefreq>daily</changefreq>';
        $sitemap .= '<priority>1.0</priority>';
        $sitemap .= '</url>';
        
        // Blog pages
        $blogs = Blog::published()->get();
        foreach ($blogs as $blog) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . route('blog.show', $blog->slug) . '</loc>';
            $sitemap .= '<lastmod>' . $blog->updated_at->format('Y-m-d') . '</lastmod>';
            $sitemap .= '<changefreq>weekly</changefreq>';
            $sitemap .= '<priority>0.8</priority>';
            $sitemap .= '</url>';
        }
        
        // Room pages
        $rooms = Room::active()->get();
        foreach ($rooms as $room) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . route('room.details', $room->slug) . '</loc>';
            $sitemap .= '<lastmod>' . $room->updated_at->format('Y-m-d') . '</lastmod>';
            $sitemap .= '<changefreq>weekly</changefreq>';
            $sitemap .= '<priority>0.8</priority>';
            $sitemap .= '</url>';
        }
        
        // Static pages
        $staticPages = [
            ['url' => route('blog.index'), 'priority' => '0.7'],
            ['url' => route('contact.index'), 'priority' => '0.6'],
        ];
        
        foreach ($staticPages as $page) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . $page['url'] . '</loc>';
            $sitemap .= '<lastmod>' . now()->format('Y-m-d') . '</lastmod>';
            $sitemap .= '<changefreq>monthly</changefreq>';
            $sitemap .= '<priority>' . $page['priority'] . '</priority>';
            $sitemap .= '</url>';
        }
        
        $sitemap .= '</urlset>';
        
        return response($sitemap, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }
}
