<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Cache;

#[Layout('components.layouts.admin')]
class SeoManagement extends Component
{
    // General SEO Settings
    public $site_title = '';
    public $site_description = '';
    public $site_keywords = '';
    public $site_author = '';
    public $site_name = '';

    // Homepage SEO
    public $home_title = '';
    public $home_description = '';
    public $home_keywords = '';

    // Rooms SEO
    public $rooms_title = '';
    public $rooms_description = '';
    public $rooms_keywords = '';

    // Blog SEO
    public $blog_title = '';
    public $blog_description = '';
    public $blog_keywords = '';

    // Contact SEO
    public $contact_title = '';
    public $contact_description = '';
    public $contact_keywords = '';

    // Social Media
    public $og_image = '';
    public $twitter_handle = '';
    public $facebook_url = '';
    public $instagram_url = '';

    // Technical SEO
    public $google_analytics = '';
    public $google_search_console = '';
    public $google_tag_manager = '';
    public $facebook_pixel = '';

    // Advanced SEO
    public $robots_txt = '';
    public $canonical_domain = '';
    public $hreflang = '';

    protected $rules = [
        'site_title' => 'required|string|max:255',
        'site_description' => 'required|string|max:500',
        'site_keywords' => 'required|string|max:500',
        'site_author' => 'required|string|max:255',
        'site_name' => 'required|string|max:255',
        'home_title' => 'required|string|max:255',
        'home_description' => 'required|string|max:500',
        'home_keywords' => 'required|string|max:500',
        'rooms_title' => 'required|string|max:255',
        'rooms_description' => 'required|string|max:500',
        'rooms_keywords' => 'required|string|max:500',
        'blog_title' => 'required|string|max:255',
        'blog_description' => 'required|string|max:500',
        'blog_keywords' => 'required|string|max:500',
        'contact_title' => 'required|string|max:255',
        'contact_description' => 'required|string|max:500',
        'contact_keywords' => 'required|string|max:500',
        'og_image' => 'nullable|string|max:500',
        'twitter_handle' => 'nullable|string|max:100',
        'facebook_url' => 'nullable|url|max:255',
        'instagram_url' => 'nullable|url|max:255',
        'google_analytics' => 'nullable|string|max:50',
        'google_search_console' => 'nullable|string|max:100',
        'google_tag_manager' => 'nullable|string|max:50',
        'facebook_pixel' => 'nullable|string|max:50',
        'robots_txt' => 'nullable|string|max:1000',
        'canonical_domain' => 'nullable|url|max:255',
        'hreflang' => 'nullable|string|max:10',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $settings = Setting::where('group', 'seo')->get()->pluck('value', 'key');
        
        // General SEO
        $this->site_title = $settings['site_title'] ?? '';
        $this->site_description = $settings['site_description'] ?? '';
        $this->site_keywords = $settings['site_keywords'] ?? '';
        $this->site_author = $settings['site_author'] ?? '';
        $this->site_name = $settings['site_name'] ?? '';

        // Homepage SEO
        $this->home_title = $settings['home_title'] ?? '';
        $this->home_description = $settings['home_description'] ?? '';
        $this->home_keywords = $settings['home_keywords'] ?? '';

        // Rooms SEO
        $this->rooms_title = $settings['rooms_title'] ?? '';
        $this->rooms_description = $settings['rooms_description'] ?? '';
        $this->rooms_keywords = $settings['rooms_keywords'] ?? '';

        // Blog SEO
        $this->blog_title = $settings['blog_title'] ?? '';
        $this->blog_description = $settings['blog_description'] ?? '';
        $this->blog_keywords = $settings['blog_keywords'] ?? '';

        // Contact SEO
        $this->contact_title = $settings['contact_title'] ?? '';
        $this->contact_description = $settings['contact_description'] ?? '';
        $this->contact_keywords = $settings['contact_keywords'] ?? '';

        // Social Media
        $this->og_image = $settings['og_image'] ?? '';
        $this->twitter_handle = $settings['twitter_handle'] ?? '';
        $this->facebook_url = $settings['facebook_url'] ?? '';
        $this->instagram_url = $settings['instagram_url'] ?? '';

        // Technical SEO
        $this->google_analytics = $settings['google_analytics'] ?? '';
        $this->google_search_console = $settings['google_search_console'] ?? '';
        $this->google_tag_manager = $settings['google_tag_manager'] ?? '';
        $this->facebook_pixel = $settings['facebook_pixel'] ?? '';

        // Advanced SEO
        $this->robots_txt = $settings['robots_txt'] ?? '';
        $this->canonical_domain = $settings['canonical_domain'] ?? '';
        $this->hreflang = $settings['hreflang'] ?? 'it';
    }

    public function save()
    {
        $this->validate();

        $settings = [
            // General SEO
            ['key' => 'site_title', 'value' => $this->site_title, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'site_description', 'value' => $this->site_description, 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'site_keywords', 'value' => $this->site_keywords, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'site_author', 'value' => $this->site_author, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'site_name', 'value' => $this->site_name, 'type' => 'text', 'group' => 'seo'],

            // Homepage SEO
            ['key' => 'home_title', 'value' => $this->home_title, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'home_description', 'value' => $this->home_description, 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'home_keywords', 'value' => $this->home_keywords, 'type' => 'text', 'group' => 'seo'],

            // Rooms SEO
            ['key' => 'rooms_title', 'value' => $this->rooms_title, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'rooms_description', 'value' => $this->rooms_description, 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'rooms_keywords', 'value' => $this->rooms_keywords, 'type' => 'text', 'group' => 'seo'],

            // Blog SEO
            ['key' => 'blog_title', 'value' => $this->blog_title, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'blog_description', 'value' => $this->blog_description, 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'blog_keywords', 'value' => $this->blog_keywords, 'type' => 'text', 'group' => 'seo'],

            // Contact SEO
            ['key' => 'contact_title', 'value' => $this->contact_title, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'contact_description', 'value' => $this->contact_description, 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'contact_keywords', 'value' => $this->contact_keywords, 'type' => 'text', 'group' => 'seo'],

            // Social Media
            ['key' => 'og_image', 'value' => $this->og_image, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'twitter_handle', 'value' => $this->twitter_handle, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'facebook_url', 'value' => $this->facebook_url, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'instagram_url', 'value' => $this->instagram_url, 'type' => 'text', 'group' => 'seo'],

            // Technical SEO
            ['key' => 'google_analytics', 'value' => $this->google_analytics, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'google_search_console', 'value' => $this->google_search_console, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'google_tag_manager', 'value' => $this->google_tag_manager, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'facebook_pixel', 'value' => $this->facebook_pixel, 'type' => 'text', 'group' => 'seo'],

            // Advanced SEO
            ['key' => 'robots_txt', 'value' => $this->robots_txt, 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'canonical_domain', 'value' => $this->canonical_domain, 'type' => 'text', 'group' => 'seo'],
            ['key' => 'hreflang', 'value' => $this->hreflang, 'type' => 'text', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }

        // Clear cache
        Cache::forget('seo_settings');

        session()->flash('success', 'Impostazioni SEO salvate con successo!');
    }

    public function resetToDefaults()
    {
        $this->loadSettings();
        session()->flash('info', 'Impostazioni ripristinate ai valori attuali.');
    }

    public function closeModal()
    {
        // Method to handle modal closing if needed
    }

    public function previewSeo($page = 'home')
    {
        // This method can be used to preview SEO settings
        $this->dispatch('seo-preview', page: $page);
    }

    public function render()
    {
        return view('livewire.admin.seo-management')
            ->title('Gestione SEO');
    }
}