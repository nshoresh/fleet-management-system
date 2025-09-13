<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Get IDs from other tables
        $vehicleTypeIds = DB::table('vehicle_types')
            ->pluck('id')
            ->toArray();
        $vehicleMakeIds = DB::table('vehicle_makes')
            ->pluck('id')
            ->toArray();
        $vehicleModelIds = DB::table('vehicle_make_models')
            ->pluck('id')
            ->toArray();
        $vehicleOwnerIds = DB::table('vehicle_owners')
            ->pluck('id')
            ->toArray();

        $vehicleClassificationIds = DB::table('vehicle_classifications')
            ->pluck('id')
            ->toArray();
        

        // Define some common data
        $engineTypes = ['Gasoline', 'Diesel', 'Electric', 'Hybrid'];
        $transmissionTypes = ['Automatic', 'Manual'];
        $fuelTypes = ['Gasoline', 'Diesel', 'Electric', 'Hybrid', 'CNG'];
        $vehicleConditions = ['New', 'Used', 'Excellent', 'Good', 'Fair', 'Poor'];
        $statuses = ['active', 'inactive'];

        // Number of vehicles to create
        $numberOfVehicles = 50;

        for ($i = 0; $i < $numberOfVehicles; $i++) {
            $makeId = $faker->randomElement($vehicleMakeIds);
            $modelId = $faker->randomElement($vehicleModelIds);

            $year = $faker->numberBetween(
                2010,
                2025
            );
            $mileage = $faker->numberBetween(
                0,
                200000
            );
            $registrationDate = $faker->dateTimeBetween(
                '-5 years',
                'now'
            );
            $lastServiceDate = $faker->dateTimeBetween(
                '-2 years',
                'now'
            );

            Vehicle::create([
                'uuid' => Vehicle::generateUniqueUuid(),
                'year' => $year,
                'vin' => Vehicle::generateUniqueVin(),
                'color' => $faker->colorName(),
                'license_plate' => strtoupper($faker->lexify('???') . $faker->numberBetween(100, 999)),
                'engine_type' => $faker->randomElement($engineTypes),
                'mileage' => $mileage,
                'registration_date' => $registrationDate,
                'status' => $faker->randomElement($statuses),
                'vehicle_make_id' => $makeId,
                'vehicle_model_id' => $modelId,
                'vehicle_owner_id' => $faker->randomElement($vehicleOwnerIds),
                'vehicle_type_id' => $faker->randomElement($vehicleTypeIds),
                'vehicle_classification_id' => $faker->randomElement($vehicleClassificationIds),
                'transmission_type' => $faker->randomElement($transmissionTypes),
                'fuel_type' => $faker->randomElement($fuelTypes),
                'seating_capacity' => $faker->numberBetween(2, 7),
                'vehicle_condition' => $faker->randomElement($vehicleConditions),
                'additional_features' => $faker->sentence(),
                'insurance_status' => $faker->boolean(),
                'last_service_date' => $lastServiceDate,
                'gross_vehicle_weight' => $faker->numberBetween(1500, 5000),
                'vehicle_tare_weight' => $faker->numberBetween(1000, 3000),
                'gross_trailer_weight' => $faker->numberBetween(0, 3000),
                'trailer_tare_weight' => $faker->numberBetween(0, 2000),
                'payload_capacity' => $faker->numberBetween(500, 2000),
                'tire_capacity' => $faker->numberBetween(4, 8),
                'axle_configuration' => $faker->randomElement(['4x2', '4x4', '6x4']),
                'number_of_axles' => $faker->numberBetween(2, 3),
                'engine_power' => $faker->numberBetween(100, 500),
                'torque' => $faker->numberBetween(200, 800),
            ]);
        }
    }
}
