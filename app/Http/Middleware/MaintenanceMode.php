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
        
        // Allow access to admin routes and auth routes even in maintenance mode
        $isAdminRoute = $request->is('admin/*') || $request->is('login') || $request->is('register');
        
        // Allow authenticated users to access the site
        $isAuthenticated = auth()->check();
        
        if ($maintenanceEnabled && !$isAdminRoute && !$isAuthenticated) {
            return response()->view('maintenance', [], 503);
        }
        
        return $next($request);
    }
}

