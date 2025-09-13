<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
       // DB::table('vehicle_classifications')->truncate();
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('vehicle_classifications')->insert([
            [
                'classification_name' => 'Heavy Truck',
                'min_weight' => 10000.00, // Minimum weight for heavy trucks in kg
                'max_weight' => null, // No maximum weight limit
                'rdc_fee' => 500.00, // Road use fee for heavy trucks in Kina
                'description' => 'Heavy trucks over 10 tons used for transporting goods over long distances.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'classification_name' => 'Medium Truck',
                'min_weight' => 6000.00, // Minimum weight for medium trucks in kg
                'max_weight' => 9999.99, // Maximum weight for medium trucks in kg
                'rdc_fee' => 300.00,  // Road use fee for medium trucks in Kina
                'description' => 'Medium-sized trucks between 6 and 10 tons for transporting goods.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'classification_name' => 'Light Truck',
                'min_weight' => 3500.00, // Minimum weight for light trucks in kg
                'max_weight' => 5999.99, // Maximum weight for light trucks in kg
                'rdc_fee' => 120.00, // Road use fee for light trucks in Kina
                'description' => 'Small-sized trucks between 3 and 6 tons for transporting goods.',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'classification_name' => 'Passenger Cars and Utes',
                'min_weight' => 0.00,
                'max_weight' => 3499.99, // Maximum weight for passenger vehicles in kg
                'rdc_fee' => 0.00, // No fee for passenger vehicles
                'description' => 'Light vehicles less than 3.5 tons, primarily used for personal transport.',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'classification_name' => 'Articulated Vehicles',
                'min_weight' => null, // No minimum weight limit
                'max_weight' => null, // No maximum weight limit
                'rdc_fee' => 700.00, // Road use fee for articulated vehicles in Kina
                'description' => 'Vehicles with a trailer or semi-trailer attached.',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'classification_name' => 'Public Motor Vehicles',
                'min_weight' => null, // No minimum weight limit
                'max_weight' => null, // No maximum weight limit
                'rdc_fee' => 120.00, // Road use fee for public motor vehicles in Kina
                'description' => 'Vehicles used for public transport services.',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
