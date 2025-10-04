<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Store or update settings.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hotel_name' => 'nullable|string|max:255',
            'hotel_description' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // General settings
        if ($request->has('hotel_name')) {
            Setting::set('hotel_name', $request->hotel_name, 'text', 'general');
        }
        
        if ($request->has('hotel_description')) {
            Setting::set('hotel_description', $request->hotel_description, 'text', 'general');
        }

        // Contact settings
        if ($request->has('contact_phone')) {
            Setting::set('contact_phone', $request->contact_phone, 'text', 'contact');
        }
        
        if ($request->has('contact_email')) {
            Setting::set('contact_email', $request->contact_email, 'text', 'contact');
        }
        
        if ($request->has('contact_address')) {
            Setting::set('contact_address', $request->contact_address, 'text', 'contact');
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('settings', 'public');
            Setting::set('logo', $logoPath, 'image', 'general');
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Impostazioni salvate con successo!');
    }
}
