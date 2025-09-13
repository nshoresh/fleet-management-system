<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HeavyVehicleMakesAndModelsSeeder extends Seeder
{
    public function run(): void
    {
        $vehicleMakes = [
            ['name' => 'Volvo Trucks', 'country' => 'Sweden', 'description' => 'Manufacturer of heavy-duty trucks and commercial vehicles.'],
            ['name' => 'Scania', 'country' => 'Sweden', 'description' => 'Premium heavy-duty trucks and buses manufacturer.'],
            ['name' => 'Mercedes-Benz Trucks', 'country' => 'Germany', 'description' => 'Commercial division of Mercedes-Benz, producing trucks and special vehicles.'],
            ['name' => 'MAN Truck & Bus', 'country' => 'Germany', 'description' => 'Manufacturer of commercial vehicles and diesel engines.'],
            ['name' => 'DAF Trucks', 'country' => 'Netherlands', 'description' => 'Commercial vehicle manufacturing company.'],
            ['name' => 'Iveco', 'country' => 'Italy', 'description' => 'Industrial vehicles manufacturer that produces light, medium and heavy commercial vehicles.'],
        ];

        $vehicleModels = [
            ['make' => 'Volvo Trucks', 'models' => [
                ['name' => 'FMX', 'year' => 2023, 'body_type' => 'Trailer', 'description' => 'Heavy-duty truck designed for tough environments.'],
                ['name' => 'FH', 'year' => 2022, 'body_type' => 'Trailer', 'description' => 'Advanced truck with safety and fuel efficiency.'],
                
            ]],
            ['make' => 'Scania', 'models' => [
                ['name' => 'R Series', 'year' => 2023, 'body_type' => 'Truck', 'description' => 'Premium long-haul truck.'],
                ['name' => 'S Series', 'year' => 2022, 'body_type' => 'Truck', 'description' => 'High-end, spacious cab for long-haul journeys.'],
                
            ]],
            ['make' => 'Mercedes-Benz Trucks', 'models' => [
                ['name' => 'Actros', 'year' => 2023, 'body_type' => 'Truck', 'description' => 'Advanced heavy-duty truck.'],
                ['name' => 'Arocs', 'year' => 2022, 'body_type' => 'Truck', 'description' => 'Heavy construction truck.'],
                
            ]],
            ['make' => 'MAN Truck & Bus', 'models' => [
                ['name' => 'TGX', 'year' => 2023, 'body_type' => 'Truck', 'description' => 'Long-distance transport truck.'],
                ['name' => 'TGS', 'year' => 2022, 'body_type' => 'Truck', 'description' => 'Versatile commercial truck.'],
                
            ]],
            ['make' => 'DAF Trucks', 'models' => [
                ['name' => 'XF', 'year' => 2023, 'body_type' => 'Truck', 'description' => 'Long-haul transportation truck.'],
                ['name' => 'CF', 'year' => 2022, 'body_type' => 'Truck', 'description' => 'Flexible all-purpose truck.'],
            ]],
            
            ['make' => 'Iveco', 'models' => [
                ['name' => 'Stralis', 'year' => 2023, 'body_type' => 'Truck', 'description' => 'Heavy-duty truck with efficient performance.'],
                ['name' => 'Eurocargo', 'year' => 2022, 'body_type' => 'Truck', 'description' => 'Medium-duty commercial truck.'],
            ]],
        ];

        $now = Carbon::now();

        foreach ($vehicleMakes as $make) {
            $makeId = DB::table('vehicle_makes')->insertGetId([
                'name' => $make['name'],
                'country' => $make['country'],
                'description' => $make['description'],
                'created_at' => $now,
                'updated_at' => $now
            ]);

            foreach ($vehicleModels as $vehicleMake) {
                if ($vehicleMake['make'] === $make['name']) {
                    foreach ($vehicleMake['models'] as $model) {
                        DB::table('vehicle_make_models')->insert([
                            'vehicle_make_id' => $makeId,
                            'name' => $model['name'],
                            'year' => $model['year'],
                            'body_type' => $model['body_type'],
                            'description' => $model['description'],
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
                    }
                }
            }
        }
    }
}
