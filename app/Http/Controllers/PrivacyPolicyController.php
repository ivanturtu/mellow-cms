<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * Display the privacy policy page
     */
    public function index()
    {
        $privacyContent = Setting::get('privacy_policy_content', '');
        $settings = Setting::getGroupedSettings();
        
        return view('privacy-policy.index', compact('privacyContent', 'settings'));
    }
}
