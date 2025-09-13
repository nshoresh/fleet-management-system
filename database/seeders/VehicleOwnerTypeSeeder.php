<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleOwnerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicle_owner_types')->insert([
            
            ['name' => 'Individual',
            'description' => 'Privately owned vehicles by individuals'
            ],

            ['name' => 'Company', 
            'description' => 'Vehicles registered under a private company'
            ],

            ['name' => 'Government', 
            'description' => 'Vehicles owned and operated by government agencies'
            ],

            ['name' => 'Military', 
            'description' => 'Vehicles used for defense and military operations'
            ],

            ['name' => 'Public Transport', 
            'description' => 'Vehicles used for passenger transportation (e.g., buses, taxis)'
            ],

            ['name' => 'Rental', 
            'description' => 'Vehicles owned by rental companies for leasing'
            ],

            ['name' => 'Commercial Fleet', 
            'description' => 'Fleet vehicles used for business purposes'
            ],

            ['name' => 'Logistics & Freight', 
            'description' => 'Vehicles used by logistics and transportation companies'
            ],

            ['name' => 'Emergency Services', 
            'description' => 'Vehicles used for fire, police, and medical emergencies'
            ],

            ['name' => 'Agriculture', 
            'description' => 'Vehicles owned by farms or agricultural companies'
            ],

            ['name' => 'Construction', 
            'description' => 'Heavy vehicles used in construction work'
            ],

            ['name' => 'Taxi Operator', 
            'description' => 'Vehicles registered under taxi service operators'
            ],

            ['name' => 'Ride-Sharing', 
            'description' => 'Privately owned vehicles used for Uber, Bolt, etc.'
            ],

            ['name' => 'Educational Institution', 
            'description' => 'Vehicles owned by universities and schools'
            ],

            ['name' => 'Non-Profit Organization', 
            'description' => 'Vehicles owned by charities and NGOs'
            ],
        ]);
    }
}
