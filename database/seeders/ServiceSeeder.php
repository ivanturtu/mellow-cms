<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Spa & Benessere',
                'description' => 'Trattamenti rilassanti e massaggi professionali per il vostro benessere totale. La nostra spa offre un\'esperienza di relax unica con terapisti esperti.',
                'image' => 'mellow/images/service1.jpg',
                'icon' => 'fas fa-spa',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Ristorante Gourmet',
                'description' => 'Cucina raffinata con ingredienti locali e internazionali. Il nostro chef prepara piatti unici che esaltano i sapori della tradizione italiana.',
                'image' => 'mellow/images/service2.jpg',
                'icon' => 'fas fa-utensils',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Centro Congressi',
                'description' => 'Sale moderne e attrezzate per eventi aziendali, matrimoni e celebrazioni speciali. Capacità fino a 200 persone con servizi audiovisivi all\'avanguardia.',
                'image' => 'mellow/images/service3.jpg',
                'icon' => 'fas fa-building',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Piscina & Fitness',
                'description' => 'Piscina coperta e palestra completamente attrezzata. Accesso 24/7 per i nostri ospiti con personal trainer disponibili su richiesta.',
                'image' => 'mellow/images/service4.jpg',
                'icon' => 'fas fa-swimming-pool',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Concierge Premium',
                'description' => 'Servizio concierge 24/7 per prenotazioni, trasferimenti, tour guidati e assistenza personalizzata. Rendiamo il vostro soggiorno indimenticabile.',
                'image' => 'mellow/images/service5.jpg',
                'icon' => 'fas fa-concierge-bell',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'Business Center',
                'description' => 'Spazi di lavoro moderni con connessione internet ad alta velocità, stampanti e servizi di segreteria per i viaggiatori d\'affari.',
                'image' => 'mellow/images/service6.jpg',
                'icon' => 'fas fa-laptop',
                'is_active' => true,
                'sort_order' => 6
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}