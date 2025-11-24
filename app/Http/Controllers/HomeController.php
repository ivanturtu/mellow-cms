<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Room;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Setting;
use App\Models\Statistic;
use App\Models\AboutSection;
use App\Http\Controllers\SeoController;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $rooms = Room::active()->ordered()->limit(6)->get();
        $gallery = Gallery::active()->ordered()->get();
        $services = Service::active()->ordered()->get();
        $blogs = Blog::published()->orderBy('published_at', 'desc')->limit(3)->get();
        $statistics = Statistic::active()->ordered()->get();
        $aboutSection = AboutSection::active()->ordered()->first();
        $settings = Setting::all()->groupBy('group')->map(function ($group) {
            return $group->pluck('value', 'key');
        });

        // SEO Data
        $seoData = SeoController::getSeoData('home');
        $page = 'home';

        return view('welcome', compact('sliders', 'rooms', 'gallery', 'services', 'blogs', 'statistics', 'aboutSection', 'settings', 'seoData', 'page'));
    }
}
