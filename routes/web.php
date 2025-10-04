<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\SettingController;

// Frontend routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Resource routes
    Route::resource('sliders', SliderController::class)->names([
        'index' => 'admin.sliders.index',
        'create' => 'admin.sliders.create',
        'store' => 'admin.sliders.store',
        'show' => 'admin.sliders.show',
        'edit' => 'admin.sliders.edit',
        'update' => 'admin.sliders.update',
        'destroy' => 'admin.sliders.destroy',
    ]);
    
    Route::resource('rooms', RoomController::class)->names([
        'index' => 'admin.rooms.index',
        'create' => 'admin.rooms.create',
        'store' => 'admin.rooms.store',
        'show' => 'admin.rooms.show',
        'edit' => 'admin.rooms.edit',
        'update' => 'admin.rooms.update',
        'destroy' => 'admin.rooms.destroy',
    ]);
    
    Route::resource('gallery', GalleryController::class)->names([
        'index' => 'admin.gallery.index',
        'create' => 'admin.gallery.create',
        'store' => 'admin.gallery.store',
        'show' => 'admin.gallery.show',
        'edit' => 'admin.gallery.edit',
        'update' => 'admin.gallery.update',
        'destroy' => 'admin.gallery.destroy',
    ]);
    
    Route::resource('services', ServiceController::class)->names([
        'index' => 'admin.services.index',
        'create' => 'admin.services.create',
        'store' => 'admin.services.store',
        'show' => 'admin.services.show',
        'edit' => 'admin.services.edit',
        'update' => 'admin.services.update',
        'destroy' => 'admin.services.destroy',
    ]);
    
    Route::resource('blogs', BlogController::class)->names([
        'index' => 'admin.blogs.index',
        'create' => 'admin.blogs.create',
        'store' => 'admin.blogs.store',
        'show' => 'admin.blogs.show',
        'edit' => 'admin.blogs.edit',
        'update' => 'admin.blogs.update',
        'destroy' => 'admin.blogs.destroy',
    ]);
    
    // Settings routes
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('admin.settings.store');
});

// Keep existing auth routes
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
