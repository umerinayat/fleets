<?php

namespace Database\Seeders;

use App\Models\Fleet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FleetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fleets = [
            [
                'fleet_number' => 44,
                'name' => 'Case CX 240-B',
                'image_url' => '/images/2.png'
            ],
            [
                'fleet_number' => 45,
                'name' => 'Sany SMG 200-3',
                'image_url' => '/images/4.png'
            ],
            [
                'fleet_number' => 46,
                'name' => 'Sany 2 SMG 200-3',
                'image_url' => '/images/1.png'
            ],
            [
                'fleet_number' => 55,
                'name' => 'Hino',
                'image_url' => '/images/3.png'
            ],
            [
                'fleet_number' => 56,
                'name' => 'Volvo G930',
                'image_url' => '/images/5.png'
            ],
            [
                'fleet_number' => 58,
                'name' => 'XCMG XE55U',
                'image_url' => '/images/6.png'
            ]
        ];

        foreach($fleets as $fleet) {
            Fleet::create($fleet);
        }
    }
}
