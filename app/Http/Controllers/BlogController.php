<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Setting;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display the blog archive page
     */
    public function index(Request $request)
    {
        $query = Blog::published()->latest('published_at');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        // Get paginated blogs
        $blogs = $query->paginate(6)->withQueryString();

        // Get all categories for filter
        $categories = Blog::published()
            ->select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();

        // Get settings for header/footer
        $settings = Setting::getGroupedSettings();

        return view('blog.index', compact('blogs', 'categories', 'settings'));
    }

    /**
     * Display a single blog post
     */
    public function show($slug)
    {
        $blog = Blog::published()->where('slug', $slug)->firstOrFail();
        
        // Get related posts (same category, excluding current)
        $relatedPosts = Blog::published()
            ->where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        // Get settings
        $settings = Setting::getGroupedSettings();

        return view('blog.show', compact('blog', 'relatedPosts', 'settings'));
    }
}