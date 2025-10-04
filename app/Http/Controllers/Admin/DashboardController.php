<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Room;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Blog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'sliders' => Slider::count(),
            'rooms' => Room::count(),
            'gallery' => Gallery::count(),
            'services' => Service::count(),
            'blogs' => Blog::count(),
            'published_blogs' => Blog::published()->count(),
        ];

        $recent_blogs = Blog::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_blogs'));
    }
}
