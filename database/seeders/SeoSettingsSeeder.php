<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SeoSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seoSettings = [
            // General SEO
            ['key' => 'site_title', 'value' => 'Hotel Mellow - Il Vostro Gateway alla Serenità', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'site_description', 'value' => 'Scoprite Hotel Mellow, il vostro rifugio di lusso nel cuore della città. Camere eleganti, servizi premium e un\'ospitalità senza pari.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'site_keywords', 'value' => 'hotel, lusso, camere, servizi, ospitalità, città, relax, mellow, soggiorno, vacanze', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'site_author', 'value' => 'Hotel Mellow', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'site_name', 'value' => 'Hotel Mellow', 'type' => 'text', 'group' => 'seo'],
            
            // Homepage SEO
            ['key' => 'home_title', 'value' => 'Hotel Mellow - Il Vostro Gateway alla Serenità', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'home_description', 'value' => 'Benvenuti a Hotel Mellow, dove comfort e tranquillità si incontrano. Scoprite le nostre camere di lusso, servizi premium e la nostra ospitalità senza pari.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'home_keywords', 'value' => 'hotel mellow, camere lusso, servizi hotel, ospitalità, relax, città, soggiorno', 'type' => 'text', 'group' => 'seo'],
            
            // Rooms SEO
            ['key' => 'rooms_title', 'value' => 'Le Nostre Camere - Hotel Mellow', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'rooms_description', 'value' => 'Scoprite le nostre camere eleganti e confortevoli. Ogni camera è stata progettata per offrire il massimo comfort e relax durante il vostro soggiorno.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'rooms_keywords', 'value' => 'camere hotel, suite, deluxe, comfort, relax, soggiorno, mellow', 'type' => 'text', 'group' => 'seo'],
            
            // Blog SEO
            ['key' => 'blog_title', 'value' => 'Blog - Hotel Mellow', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'blog_description', 'value' => 'Scoprite le ultime novità, consigli e informazioni su Hotel Mellow e la nostra ospitalità.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'blog_keywords', 'value' => 'blog hotel, novità, consigli, ospitalità, mellow, notizie', 'type' => 'text', 'group' => 'seo'],
            
            // Contact SEO
            ['key' => 'contact_title', 'value' => 'Contatti - Hotel Mellow', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'contact_description', 'value' => 'Contattateci per prenotazioni, informazioni o richieste speciali. Il nostro team è a vostra disposizione.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'contact_keywords', 'value' => 'contatti hotel, prenotazioni, informazioni, assistenza, mellow', 'type' => 'text', 'group' => 'seo'],
            
            // Social Media
            ['key' => 'og_image', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'twitter_handle', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            
            // Technical SEO
            ['key' => 'google_analytics', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'google_search_console', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'google_tag_manager', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'facebook_pixel', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            
            // Advanced SEO
            ['key' => 'robots_txt', 'value' => '', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'canonical_domain', 'value' => '', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'hreflang', 'value' => 'it', 'type' => 'text', 'group' => 'seo'],
        ];

        foreach ($seoSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key'], 'group' => $setting['group']],
                $setting
            );
        }
    }
}