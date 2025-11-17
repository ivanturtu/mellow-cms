<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\PrivacyPolicyController;

// Frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/room/{slug}', [App\Http\Controllers\RoomController::class, 'show'])->name('room.details');
Route::post('/booking-request', [App\Http\Controllers\BookingRequestController::class, 'store'])->name('booking.request');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Contact routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Privacy Policy route
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy');

// Newsletter routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
Route::get('/newsletter/check', [NewsletterController::class, 'checkSubscription'])->name('newsletter.check');

// SEO routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [RobotsController::class, 'index'])->name('robots');

// Admin redirect route - redirects to dashboard if authenticated, otherwise to login
// This route must be defined BEFORE the admin prefix to avoid conflicts
Route::get('/admin', function () {
    if (auth()->check() && auth()->user()->hasVerifiedEmail()) {
        return redirect()->route('admin.dashboard');
    }
    if (auth()->check()) {
        return redirect()->route('verification.notice');
    }
    return redirect()->route('login');
})->name('admin');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Livewire Admin Routes
    Route::get('/sliders', \App\Livewire\Admin\SliderManagement::class)->name('admin.sliders');
    Route::get('/rooms', \App\Livewire\Admin\RoomManagement::class)->name('admin.rooms');
    Route::get('/gallery', \App\Livewire\Admin\GalleryManagement::class)->name('admin.gallery');
    Route::get('/services', \App\Livewire\Admin\ServiceManagement::class)->name('admin.services');
    Route::get('/blogs', \App\Livewire\Admin\BlogManagement::class)->name('admin.blogs');
            Route::get('/settings', \App\Livewire\Admin\SettingsManagement::class)->name('admin.settings');
            Route::get('/statistics', \App\Livewire\Admin\StatisticManagement::class)->name('admin.statistics');
            Route::get('/about', \App\Livewire\Admin\AboutManagement::class)->name('admin.about');
    Route::get('/booking-requests', \App\Livewire\Admin\BookingRequestManagement::class)->name('admin.booking-requests');
    Route::get('/contact-messages', \App\Livewire\Admin\ContactMessageManagement::class)->name('admin.contact-messages');
    Route::get('/seo', \App\Livewire\Admin\SeoManagement::class)->name('admin.seo');
});

// Keep existing auth routes
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
