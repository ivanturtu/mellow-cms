<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    /**
     * Get SEO data for a page
     */
    public static function getSeoData($page = 'home', $data = [])
    {
        $settings = Setting::getGroupedSettings();
        
        $defaultSeo = [
            'title' => $settings['seo']['site_title'] ?? 'Hotel Mellow - Il Vostro Gateway alla Serenità',
            'description' => $settings['seo']['site_description'] ?? 'Scoprite Hotel Mellow, il vostro rifugio di lusso nel cuore della città. Camere eleganti, servizi premium e un\'ospitalità senza pari.',
            'keywords' => $settings['seo']['site_keywords'] ?? 'hotel, lusso, camere, servizi, ospitalità, città, relax',
            'author' => $settings['seo']['site_author'] ?? 'Hotel Mellow',
            'robots' => 'index, follow',
            'og_type' => 'website',
            'og_site_name' => $settings['seo']['site_name'] ?? 'Hotel Mellow',
            'twitter_card' => 'summary_large_image',
            'canonical' => url()->current(),
            'og_image' => $settings['seo']['og_image'] ?? asset('mellow/images/og-image.jpg'),
            'twitter_handle' => $settings['seo']['twitter_handle'] ?? '',
        ];

        switch ($page) {
            case 'home':
                return array_merge($defaultSeo, [
                    'title' => $settings['seo']['home_title'] ?? 'Hotel Mellow - Il Vostro Gateway alla Serenità',
                    'description' => $settings['seo']['home_description'] ?? 'Benvenuti a Hotel Mellow, dove comfort e tranquillità si incontrano. Scoprite le nostre camere di lusso, servizi premium e la nostra ospitalità senza pari.',
                    'keywords' => $settings['seo']['home_keywords'] ?? 'hotel mellow, camere lusso, servizi hotel, ospitalità, relax, città',
                    'og_type' => 'website',
                ]);
                
            case 'rooms':
                return array_merge($defaultSeo, [
                    'title' => $settings['seo']['rooms_title'] ?? 'Le Nostre Camere - Hotel Mellow',
                    'description' => $settings['seo']['rooms_description'] ?? 'Scoprite le nostre camere eleganti e confortevoli. Ogni camera è stata progettata per offrire il massimo comfort e relax durante il vostro soggiorno.',
                    'keywords' => $settings['seo']['rooms_keywords'] ?? 'camere hotel, suite, deluxe, comfort, relax, soggiorno',
                ]);
                
            case 'blog':
                return array_merge($defaultSeo, [
                    'title' => $settings['seo']['blog_title'] ?? 'Blog - Hotel Mellow',
                    'description' => $settings['seo']['blog_description'] ?? 'Scoprite le ultime novità, consigli e informazioni su Hotel Mellow e la nostra ospitalità.',
                    'keywords' => $settings['seo']['blog_keywords'] ?? 'blog hotel, novità, consigli, ospitalità, mellow',
                ]);
                
            case 'contact':
                return array_merge($defaultSeo, [
                    'title' => $settings['seo']['contact_title'] ?? 'Contatti - Hotel Mellow',
                    'description' => $settings['seo']['contact_description'] ?? 'Contattateci per prenotazioni, informazioni o richieste speciali. Il nostro team è a vostra disposizione.',
                    'keywords' => $settings['seo']['contact_keywords'] ?? 'contatti hotel, prenotazioni, informazioni, assistenza',
                ]);
                
            default:
                return $defaultSeo;
        }
    }

    /**
     * Generate structured data for hotel
     */
    public static function getHotelStructuredData()
    {
        $settings = Setting::getGroupedSettings();
        
        return [
            "@context" => "https://schema.org",
            "@type" => "Hotel",
            "name" => $settings['general']['hotel_name'] ?? 'Hotel Mellow',
            "description" => $settings['general']['hotel_description'] ?? 'Il vostro gateway alla serenità',
            "url" => url('/'),
            "telephone" => $settings['contact']['contact_phone'] ?? '',
            "email" => $settings['contact']['contact_email'] ?? '',
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => $settings['contact']['contact_address'] ?? '',
                "addressLocality" => $settings['contact']['contact_city'] ?? '',
                "addressRegion" => $settings['contact']['contact_state'] ?? '',
                "postalCode" => $settings['contact']['contact_zip'] ?? '',
                "addressCountry" => $settings['contact']['contact_country'] ?? 'IT'
            ],
            "image" => asset($settings['general']['logo'] ?? 'mellow/images/main-logo.png'),
            "starRating" => [
                "@type" => "Rating",
                "ratingValue" => "5"
            ],
            "amenityFeature" => [
                "WiFi",
                "Parking",
                "Restaurant",
                "Spa",
                "Pool",
                "Fitness Center"
            ]
        ];
    }

    /**
     * Generate breadcrumb structured data
     */
    public static function getBreadcrumbStructuredData($items)
    {
        $breadcrumbList = [
            "@context" => "https://schema.org",
            "@type" => "BreadcrumbList",
            "itemListElement" => []
        ];

        foreach ($items as $index => $item) {
            $breadcrumbList["itemListElement"][] = [
                "@type" => "ListItem",
                "position" => $index + 1,
                "name" => $item['name'],
                "item" => $item['url'] ?? null
            ];
        }

        return $breadcrumbList;
    }

    /**
     * Generate FAQ structured data
     */
    public static function getFaqStructuredData($faqs)
    {
        $faqData = [
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "mainEntity" => []
        ];

        foreach ($faqs as $faq) {
            $faqData["mainEntity"][] = [
                "@type" => "Question",
                "name" => $faq['question'],
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => $faq['answer']
                ]
            ];
        }

        return $faqData;
    }
}
