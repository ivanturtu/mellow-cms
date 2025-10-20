<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Statistic;

class StatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statistics = [
            [
                'title' => 'Clienti Soddisfatti',
                'value' => '25K',
                'description' => 'Ospiti che hanno scelto la nostra struttura',
                'icon' => 'fas fa-users',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'Camere Totali',
                'value' => '4',
                'description' => 'Camere eleganti e confortevoli',
                'icon' => 'fas fa-bed',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Premi Vinti',
                'value' => '25',
                'description' => 'Riconoscimenti per la qualità del servizio',
                'icon' => 'fas fa-trophy',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'title' => 'Membri Totali',
                'value' => '200',
                'description' => 'Membri del nostro team dedicato',
                'icon' => 'fas fa-user-friends',
                'is_active' => true,
                'sort_order' => 4
            ]
        ];

        foreach ($statistics as $statistic) {
            Statistic::create($statistic);
        }
    }
}
