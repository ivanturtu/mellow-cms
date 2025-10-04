<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Room;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $rooms = Room::active()->ordered()->limit(6)->get();
        $gallery = Gallery::active()->ordered()->limit(6)->get();
        $services = Service::active()->ordered()->get();
        $blogs = Blog::published()->orderBy('published_at', 'desc')->limit(3)->get();
        $settings = Setting::all()->groupBy('group')->map(function ($group) {
            return $group->pluck('value', 'key');
        });

        return view('welcome', compact('sliders', 'rooms', 'gallery', 'services', 'blogs', 'settings'));
    }
}
