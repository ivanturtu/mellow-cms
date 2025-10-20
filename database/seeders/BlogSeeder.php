<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blogs = [
            [
                'title' => 'Benvenuti nella Valle Peligna',
                'slug' => 'benvenuti-valle-peligna',
                'excerpt' => 'Scoprite le bellezze naturali e storiche della nostra regione',
                'content' => 'La Valle Peligna è una terra ricca di storia e tradizioni. Dai resti archeologici di Corfinium alle bellezze naturali del Parco Nazionale della Majella, ogni angolo racconta una storia affascinante. Il nostro hotel è il punto di partenza ideale per esplorare questa meravigliosa regione.',
                'image' => 'mellow/images/blog1.jpg',
                'category' => 'turismo',
                'is_published' => true,
                'published_at' => now()->subDays(5)
            ],
            [
                'title' => 'La Cucina Tradizionale Abruzzese',
                'slug' => 'cucina-tradizionale-abruzzese',
                'excerpt' => 'I sapori autentici della nostra terra nel nostro ristorante',
                'content' => 'La tradizione culinaria abruzzese è ricca di sapori unici e genuini. Dal famoso arrosticini alle sagne e fagioli, passando per i dolci tipici come le ferratelle. Il nostro chef reinterpreta questi piatti della tradizione con un tocco moderno, offrendo un\'esperienza gastronomica indimenticabile.',
                'image' => 'mellow/images/blog2.jpg',
                'category' => 'gastronomia',
                'is_published' => true,
                'published_at' => now()->subDays(3)
            ],
            [
                'title' => 'Eventi e Celebrazioni Speciali',
                'slug' => 'eventi-celebrazioni-speciali',
                'excerpt' => 'Organizziamo il vostro evento perfetto in un ambiente esclusivo',
                'content' => 'Che si tratti di un matrimonio romantico, di una conferenza aziendale o di una festa di compleanno, il nostro hotel offre spazi eleganti e servizi personalizzati per rendere ogni evento unico e indimenticabile. Il nostro team di eventi vi accompagnerà in ogni fase dell\'organizzazione.',
                'image' => 'mellow/images/blog3.jpg',
                'category' => 'eventi',
                'is_published' => true,
                'published_at' => now()->subDays(1)
            ]
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }
    }
}