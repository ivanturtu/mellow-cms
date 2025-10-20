<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleryItems = [
            [
                'title' => 'Lobby Elegante',
                'description' => 'Il nostro accogliente lobby con design moderno',
                'image' => 'mellow/images/gallery1.jpg',
                'category' => 'hotel',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'Camera Deluxe',
                'description' => 'Una delle nostre camere più spaziose',
                'image' => 'mellow/images/gallery2.jpg',
                'category' => 'rooms',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Ristorante Panoramico',
                'description' => 'Il nostro ristorante con vista mozzafiato',
                'image' => 'mellow/images/gallery3.jpg',
                'category' => 'restaurant',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'title' => 'Spa Relax',
                'description' => 'Area benessere per il relax totale',
                'image' => 'mellow/images/gallery4.jpg',
                'category' => 'spa',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'title' => 'Piscina Esterna',
                'description' => 'Piscina con vista panoramica sulla città',
                'image' => 'mellow/images/gallery5.jpg',
                'category' => 'pool',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'title' => 'Terrazza Sunset',
                'description' => 'Terrazza privata per aperitivi al tramonto',
                'image' => 'mellow/images/gallery6.jpg',
                'category' => 'terrace',
                'is_active' => true,
                'sort_order' => 6
            ]
        ];

        foreach ($galleryItems as $item) {
            Gallery::create($item);
        }
    }
}