<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\Room;
use App\Models\Blog;
use App\Models\Slider;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\AboutSection;
use Illuminate\Database\Seeder;

class CurrentDataSeeder extends Seeder
{
    /**
     * Seed the application's database with current data.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mellow.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Settings
        Setting::create([
            "key" => "hotel_name",
            "value" => "Civico 41",
            "type" => "text",
            "group" => "general"
        ]);

        Setting::create([
            "key" => "hotel_description",
            "value" => "Il vostro gateway alla valle peligna",
            "type" => "text",
            "group" => "general"
        ]);

        Setting::create([
            "key" => "contact_phone",
            "value" => "+39 353 398 4455",
            "type" => "text",
            "group" => "general"
        ]);

        Setting::create([
            "key" => "contact_email",
            "value" => "casavacanzecivico41@gmail.com",
            "type" => "text",
            "group" => "general"
        ]);

        Setting::create([
            "key" => "contact_address",
            "value" => "Via S. Antonio, 41, 67034 Pettorano sul Gizio",
            "type" => "text",
            "group" => "general"
        ]);

        Setting::create([
            "key" => "logo",
            "value" => "logos/IzpZTexhvg0R4fqGWQWbrV9A7i5olnqmTurOE11K.png",
            "type" => "text",
            "group" => "general"
        ]);

        Setting::create([
            "key" => "map_latitude",
            "value" => "41.97326000",
            "type" => "text",
            "group" => "general"
        ]);

        Setting::create([
            "key" => "map_longitude",
            "value" => "13.96001000",
            "type" => "text",
            "group" => "general"
        ]);

        Setting::create([
            "key" => "map_zoom",
            "value" => "16",
            "type" => "text",
            "group" => "general"
        ]);

        // SEO Settings
        Setting::create([
            "key" => "site_title",
            "value" => "Civico 41 Pettorano sul gizio  - Il Vostro Gateway alla Valle Peligna",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "site_description",
            "value" => "Scoprite Hotel Mellow, il vostro rifugio di lusso nel cuore della città. Camere eleganti, servizi premium e un'ospitalità senza pari.",
            "type" => "textarea",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "site_keywords",
            "value" => "hotel, lusso, camere, servizi, ospitalità, città, relax, mellow, soggiorno, vacanze",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "site_author",
            "value" => "Hotel Mellow",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "site_name",
            "value" => "Civico 41 Pettorano sul gizio  - Il Vostro Gateway alla Valle Peligna",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "home_title",
            "value" => "Civico 41 Pettorano sul gizio  - Il Vostro Gateway alla Valle Peligna",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "home_description",
            "value" => "Benvenuti a Hotel Mellow, dove comfort e tranquillità si incontrano. Scoprite le nostre camere di lusso, servizi premium e la nostra ospitalità senza pari.",
            "type" => "textarea",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "home_keywords",
            "value" => "hotel mellow, camere lusso, servizi hotel, ospitalità, relax, città, soggiorno",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "rooms_title",
            "value" => "Le Nostre Camere - Civico 41 Pettorano sul gizio",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "rooms_description",
            "value" => "Scoprite le nostre camere eleganti e confortevoli. Ogni camera è stata progettata per offrire il massimo comfort e relax durante il vostro soggiorno.",
            "type" => "textarea",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "rooms_keywords",
            "value" => "camere hotel, suite, deluxe, comfort, relax, soggiorno, mellow",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "blog_title",
            "value" => "Blog - Civico 41 Pettorano sul gizio",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "blog_description",
            "value" => "Scoprite le ultime novità, consigli e informazioni su Hotel Mellow e la nostra ospitalità.",
            "type" => "textarea",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "blog_keywords",
            "value" => "blog hotel, novità, consigli, ospitalità, mellow, notizie",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "contact_title",
            "value" => "Contatti - Hotel Mellow",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "contact_description",
            "value" => "Contattateci per prenotazioni, informazioni o richieste speciali. Il nostro team è a vostra disposizione.",
            "type" => "textarea",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "contact_keywords",
            "value" => "contatti hotel, prenotazioni, informazioni, assistenza, mellow",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "og_image",
            "value" => "",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "google_analytics",
            "value" => "",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "google_search_console",
            "value" => "",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "google_tag_manager",
            "value" => "",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "facebook_pixel",
            "value" => "",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "robots_txt",
            "value" => "",
            "type" => "textarea",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "canonical_domain",
            "value" => "",
            "type" => "text",
            "group" => "seo"
        ]);

        Setting::create([
            "key" => "hreflang",
            "value" => "it",
            "type" => "text",
            "group" => "seo"
        ]);

        // Social Settings
        Setting::create([
            "key" => "facebook_url",
            "value" => "https://www.facebook.com/profile.php?id=61579883990080",
            "type" => "url",
            "group" => "social"
        ]);

        Setting::create([
            "key" => "instagram_url",
            "value" => "",
            "type" => "url",
            "group" => "social"
        ]);

        Setting::create([
            "key" => "tiktok_url",
            "value" => "",
            "type" => "url",
            "group" => "social"
        ]);

        Setting::create([
            "key" => "whatsapp_url",
            "value" => "https://wa.me/393533984455",
            "type" => "tel",
            "group" => "social"
        ]);

        Setting::create([
            "key" => "linkedin_url",
            "value" => "",
            "type" => "url",
            "group" => "social"
        ]);

        // Mailchimp Settings
        Setting::create([
            "key" => "mailchimp_api_key",
            "value" => "aa",
            "type" => "text",
            "group" => "mailchimp"
        ]);

        // Rooms
        Room::create([
            "name" => "Camera Matrimoniale",
            "description" => "una camera molto comoda",
            "image" => "rooms/uBD9hQ6G9jFgeAl0wAPPPZ7FZIfgQVozR6sku2sF_md.webp",
            "price" => 80.00,
            "size" => "25mq",
            "capacity" => 2,
            "bed_count" => 1,
            "bath_count" => 1,
            "bed_type" => "Matrimoniale",
            "services" => "",
            "wifi" => true,
            "air_conditioning" => true,
            "tv_cable" => true,
            "is_active" => true,
            "sort_order" => 0,
            "slug" => "camera-matrimoniale"
        ]);

        Room::create([
            "name" => "Camera Doppia",
            "description" => "una camera molto carina",
            "image" => "rooms/yrm9EZUuQa4ipl0JppT9KBme0IUUoGRmCrnlEb3A_md.webp",
            "price" => 70.00,
            "size" => "20",
            "capacity" => 2,
            "bed_count" => 1,
            "bath_count" => 1,
            "bed_type" => "Due letti singoli",
            "services" => "",
            "wifi" => true,
            "air_conditioning" => true,
            "tv_cable" => true,
            "is_active" => true,
            "sort_order" => 0,
            "slug" => "camera-doppia"
        ]);

        // Blogs
        Blog::create([
            "title" => "Le Nostre Camere di Lusso",
            "excerpt" => "Scoprite le nostre camere eleganti e confortevoli, progettate per il vostro relax",
            "content" => "Ogni camera del nostro hotel è stata progettata con cura per offrire il massimo comfort e relax. Dalle camere standard alle suite di lusso, ogni spazio riflette la nostra attenzione ai dettagli e la passione per l'ospitalità.",
            "image" => "blogs/CO2FG8kQjanKF76RqnjzkVm9L8i8CbYNzkPNDW9a.jpg",
            "image_sizes" => "{\"xs\":{\"path\":\"blogs\\/CO2FG8kQjanKF76RqnjzkVm9L8i8CbYNzkPNDW9a_xs.webp\",\"width\":400,\"url\":\"http:\\/\\/mellow-cms.test\\/storage\\/blogs\\/CO2FG8kQjanKF76RqnjzkVm9L8i8CbYNzkPNDW9a_xs.webp\"},\"sm\":{\"path\":\"blogs\\/CO2FG8kQjanKF76RqnjzkVm9L8i8CbYNzkPNDW9a_sm.webp\",\"width\":600,\"url\":\"http:\\/\\/mellow-cms.test\\/storage\\/blogs\\/CO2FG8kQjanKF76RqnjzkVm9L8i8CbYNzkPNDW9a_sm.webp\"},\"md\":{\"path\":\"blogs\\/CO2FG8kQjanKF76RqnjzkVm9L8i8CbYNzkPNDW9a_md.webp\",\"width\":800,\"url\":\"http:\\/\\/mellow-cms.test\\/storage\\/blogs\\/CO2FG8kQjanKF76RqnjzkVm9L8i8CbYNzkPNDW9a_md.webp\"},\"lg\":{\"path\":\"blogs\\/CO2FG8kQjanKF76RqnjzkVm9L8i8CbYNzkPNDW9a_lg.webp\",\"width\":1200,\"url\":\"http:\\/\\/mellow-cms.test\\/storage\\/blogs\\/CO2FG8kQjanKF76RqnjzkVm9L8i8CbYNzkPNDW9a_lg.webp\"},\"xl\":{\"path\":\"blogs\\/CO2FG8kQjanKF76RqnjzkVm9L8i8CbYNzkPNDW9a_xl.webp\",\"width\":1920,\"url\":\"http:\\/\\/mellow-cms.test\\/storage\\/blogs\\/CO2FG8kQjanKF76RqnjzkVm9L8i8CbYNzkPNDW9a_xl.webp\"}}",
            "category" => "Camere",
            "slug" => "le-nostre-camere-di-lusso",
            "is_published" => true,
            "published_at" => "2025-10-02 19:37:00"
        ]);

        Blog::create([
            "title" => "Benvenuti a Hotel Mellow",
            "excerpt" => "Scoprite la nostra filosofia di ospitalità",
            "content" => "Benvenuti a Hotel Mellow, dove ogni dettaglio è curato per offrirvi un'esperienza indimenticabile. La nostra filosofia si basa su tre pilastri fondamentali: comfort, eleganza e servizio personalizzato.",
            "image" => "mellow/images/post1.jpg",
            "image_sizes" => null,
            "category" => "Hotel",
            "slug" => "benvenuti-a-hotel-mellow",
            "is_published" => true,
            "published_at" => "2025-10-04 19:01:48"
        ]);

        Blog::create([
            "title" => "Spa & Wellness: Il Vostro Benessere",
            "excerpt" => "Rigeneratevi nel nostro centro benessere con trattamenti esclusivi",
            "content" => "Il nostro centro benessere offre una vasta gamma di trattamenti per il corpo e la mente. Dalla sauna al bagno turco, dai massaggi rilassanti alle terapie estetiche, tutto è pensato per il vostro benessere totale.",
            "image" => "mellow/images/post3.jpg",
            "image_sizes" => null,
            "category" => "Servizi",
            "slug" => "spa-wellness-benessere",
            "is_published" => true,
            "published_at" => "2025-09-29 19:37:35"
        ]);

        Blog::create([
            "title" => "Eventi e Matrimoni",
            "excerpt" => "Organizzate il vostro evento speciale nel nostro hotel",
            "content" => "Hotel Mellow è la location perfetta per i vostri eventi speciali. Con sale eleganti, servizio catering di alta qualità e un team dedicato, renderemo indimenticabile il vostro matrimonio, meeting aziendale o celebrazione privata.",
            "image" => "mellow/images/post4.jpg",
            "image_sizes" => null,
            "category" => "Eventi",
            "slug" => "eventi-matrimoni",
            "is_published" => true,
            "published_at" => "2025-09-27 19:37:35"
        ]);
    }
}
