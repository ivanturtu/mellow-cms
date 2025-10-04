<?php

namespace Database\Seeders;

use App\Models\Slider;
use App\Models\Room;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Blog;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create additional sliders
        Slider::create([
            'title' => 'Un Oasi di Tranquillità',
            'description' => 'Scopri il comfort e l\'eleganza delle nostre camere',
            'image' => 'mellow/images/slider-image2.jpg',
            'cta_text' => 'Prenota Ora',
            'cta_link' => '#booking',
            'is_active' => true,
            'sort_order' => 2
        ]);

        // Create additional rooms
        Room::create([
            'name' => 'Executive Suite',
            'description' => 'Camera di lusso con vista sulla città e servizi premium',
            'image' => 'mellow/images/room3.jpg',
            'price' => 650.00,
            'size' => '65 m²',
            'capacity' => 2,
            'bed_type' => 'King Size Premium',
            'services' => 'WiFi, TV 55", Minibar, Aria condizionata, Bagno privato con vasca, Balcone, Servizio in camera',
            'is_active' => true,
            'sort_order' => 3
        ]);

        Room::create([
            'name' => 'Standard Room',
            'description' => 'Camera confortevole e moderna per un soggiorno piacevole',
            'image' => 'mellow/images/room4.jpg',
            'price' => 199.00,
            'size' => '25 m²',
            'capacity' => 2,
            'bed_type' => 'Queen Size',
            'services' => 'WiFi, TV, Aria condizionata, Bagno privato',
            'is_active' => true,
            'sort_order' => 4
        ]);

        // Create additional gallery items
        Gallery::create([
            'title' => 'Sala Colazioni',
            'description' => 'Colazione a buffet con vista panoramica',
            'image' => 'mellow/images/item3.jpg',
            'category' => 'Servizi',
            'is_active' => true,
            'sort_order' => 3
        ]);

        Gallery::create([
            'title' => 'Spa & Wellness',
            'description' => 'Centro benessere per il relax totale',
            'image' => 'mellow/images/item4.jpg',
            'category' => 'Servizi',
            'is_active' => true,
            'sort_order' => 4
        ]);

        Gallery::create([
            'title' => 'Terrazza Panoramica',
            'description' => 'Terrazza con vista mozzafiato sulla città',
            'image' => 'mellow/images/item5.jpg',
            'category' => 'Viste',
            'is_active' => true,
            'sort_order' => 5
        ]);

        Gallery::create([
            'title' => 'Lobby Elegante',
            'description' => 'Hall di ingresso con design moderno',
            'image' => 'mellow/images/item6.jpg',
            'category' => 'Interni',
            'is_active' => true,
            'sort_order' => 6
        ]);

        // Create additional services
        Service::create([
            'name' => 'Spa & Wellness',
            'description' => 'Centro benessere completo con sauna, bagno turco e trattamenti',
            'icon' => 'spa',
            'is_active' => true,
            'sort_order' => 4
        ]);

        Service::create([
            'name' => 'Concierge 24/7',
            'description' => 'Servizio concierge disponibile 24 ore su 24 per ogni vostra esigenza',
            'icon' => 'concierge',
            'is_active' => true,
            'sort_order' => 5
        ]);

        Service::create([
            'name' => 'Business Center',
            'description' => 'Sala riunioni e servizi business per i viaggiatori d\'affari',
            'icon' => 'business',
            'is_active' => true,
            'sort_order' => 6
        ]);

        // Create additional blogs
        Blog::create([
            'title' => 'Le Nostre Camere di Lusso',
            'excerpt' => 'Scoprite le nostre camere eleganti e confortevoli, progettate per il vostro relax',
            'content' => 'Ogni camera del nostro hotel è stata progettata con cura per offrire il massimo comfort e relax. Dalle camere standard alle suite di lusso, ogni spazio riflette la nostra attenzione ai dettagli e la passione per l\'ospitalità.',
            'image' => 'mellow/images/post2.jpg',
            'category' => 'Camere',
            'slug' => 'nostre-camere-lusso',
            'is_published' => true,
            'published_at' => now()->subDays(2)
        ]);

        Blog::create([
            'title' => 'Spa & Wellness: Il Vostro Benessere',
            'excerpt' => 'Rigeneratevi nel nostro centro benessere con trattamenti esclusivi',
            'content' => 'Il nostro centro benessere offre una vasta gamma di trattamenti per il corpo e la mente. Dalla sauna al bagno turco, dai massaggi rilassanti alle terapie estetiche, tutto è pensato per il vostro benessere totale.',
            'image' => 'mellow/images/post3.jpg',
            'category' => 'Servizi',
            'slug' => 'spa-wellness-benessere',
            'is_published' => true,
            'published_at' => now()->subDays(5)
        ]);

        Blog::create([
            'title' => 'Eventi e Matrimoni',
            'excerpt' => 'Organizzate il vostro evento speciale nel nostro hotel',
            'content' => 'Hotel Mellow è la location perfetta per i vostri eventi speciali. Con sale eleganti, servizio catering di alta qualità e un team dedicato, renderemo indimenticabile il vostro matrimonio, meeting aziendale o celebrazione privata.',
            'image' => 'mellow/images/post4.jpg',
            'category' => 'Eventi',
            'slug' => 'eventi-matrimoni',
            'is_published' => true,
            'published_at' => now()->subDays(7)
        ]);
    }
}