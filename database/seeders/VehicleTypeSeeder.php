<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vehicle_types')->insert([
            // Non-Industrial Vehicles
            [
                'name' => 'Sedan',
                'description' => 'A small to medium-sized passenger car',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Hatchback',
                'description' => 'A compact car with a rear door that swings upwards',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'SUV',
                'description' => 'A sport utility vehicle with off-road capabilities',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Pickup Truck',
                'description' => 'A light truck with an open cargo area',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Van',
                'description' => 'A medium to large-sized vehicle for transporting goods or people',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bus',
                'description' => 'A large vehicle designed to carry passengers',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Motorcycle',
                'description' => 'A two-wheeled motor vehicle',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Electric Vehicle',
                'description' => 'A vehicle powered entirely by electricity',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Industrial & Heavy Vehicles
            [
                'name' => 'Dump Truck',
                'description' => 'A heavy-duty truck used for transporting materials like gravel or sand',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Excavator',
                'description' => 'A construction vehicle used for digging and moving large objects',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bulldozer',
                'description' => 'A powerful tracked vehicle with a large metal plate used for pushing material',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Backhoe Loader',
                'description' => 'A tractor-like vehicle with a front loader and rear digging bucket',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Crane Truck',
                'description' => 'A truck-mounted crane used for lifting heavy loads',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Forklift',
                'description' => 'A powered industrial truck used to lift and move materials',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Concrete Mixer Truck',
                'description' => 'A truck designed to mix and transport concrete',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tanker Truck',
                'description' => 'A truck used for transporting liquids like fuel, chemicals, or water',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Fire Truck',
                'description' => 'A specialized vehicle designed for firefighting operations',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Garbage Truck',
                'description' => 'A truck designed for collecting and transporting waste materials',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Logging Truck',
                'description' => 'A heavy-duty truck used for transporting logs',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Road Roller',
                'description' => 'A construction vehicle used to compact soil, gravel, or asphalt',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tractor',
                'description' => 'An agricultural vehicle used for pulling farm equipment',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Harvesting Combine',
                'description' => 'A machine used for harvesting crops',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Snowplow Truck',
                'description' => 'A truck equipped with a snowplow for clearing roads',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Oil Tanker Ship',
                'description' => 'A large vessel used for transporting oil',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cargo Truck',
                'description' => 'A heavy truck used for transporting goods over long distances',
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Specialized Vehicles
            [
                'name' => 'Ambulance',
                'description' => 'A vehicle designed for emergency medical transport',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Military Armored Vehicle',
                'description' => 'A heavily armored vehicle used for defense purposes',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Tow Truck',
                'description' => 'A vehicle used for towing disabled cars',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Street Sweeper',
                'description' => 'A truck equipped with rotating brushes to clean streets',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Car Carrier Truck',
                'description' => 'A specialized truck used to transport multiple vehicles',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Trailer',
                'description' => 'A non-motorized vehicle designed to be towed by a truck, tractor, or other powered vehicle.',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
