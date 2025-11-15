<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if maintenance mode is enabled
        $maintenanceEnabled = Setting::get('maintenance_enabled', '0') === '1';
        
        // Allow access to admin routes, auth routes, and Livewire requests even in maintenance mode
        $isAdminRoute = $request->is('admin/*') || $request->is('login') || $request->is('register');
        $isLivewireRequest = $request->is('livewire/*') || $request->header('X-Livewire');
        $isAuthRoute = $request->is('login') || $request->is('register') || $request->is('logout') || $request->is('password/*');
        
        // Allow authenticated users to access the site
        $isAuthenticated = auth()->check();
        
        // Allow Livewire requests and auth routes even in maintenance mode
        if ($maintenanceEnabled && !$isAdminRoute && !$isAuthenticated && !$isLivewireRequest && !$isAuthRoute) {
            return response()->view('maintenance', [], 503);
        }
        
        return $next($request);
    }
}

