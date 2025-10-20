<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'name' => 'Grand Deluxe Room',
            'description' => 'Una camera spaziosa e confortevole con vista panoramica',
            'image' => 'mellow/images/room1.jpg',
            'price' => 299.00,
            'size' => '35 m²',
            'capacity' => 2,
            'bed_type' => 'King Size',
            'services' => 'WiFi, TV, Minibar, Aria condizionata, Bagno privato',
            'is_active' => true,
            'sort_order' => 1
        ]);

        Room::create([
            'name' => 'Family Suite',
            'description' => 'Perfetta per famiglie con bambini, spaziosa e accogliente',
            'image' => 'mellow/images/room2.jpg',
            'price' => 450.00,
            'size' => '50 m²',
            'capacity' => 4,
            'bed_type' => 'Due letti matrimoniali',
            'services' => 'WiFi, TV, Minibar, Aria condizionata, Bagno privato, Balcone',
            'is_active' => true,
            'sort_order' => 2
        ]);

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
    }
}