<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\District;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RegionSeeder::class,
            ProvinceSeeder::class,
            RouteTypeSeeder::class,
            RouteSeeder::class,
            // Distr::class,
            VehicleTypeSeeder::class,
            VehicleOwnerTypeSeeder::class,
            TransmissionTypeSeeder::class,
            VehicleColorSeeder::class,
            FuelTypeSeeder::class,
            RouteSeeder::class,
            AccountStatusSeeder::class,
            AccountStatusSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            RolePermissionSeeder::class,
            LicenseTypeSeeder::class,
            LicensePurposeSeeder::class,
            HeavyVehicleMakesAndModelsSeeder::class,
            UserTypeSeeder::class,
            UserSeeder::class,
            VehicleOwnerSeeder::class,
            RfidScannersTableSeeder::class,
            VehicleClassificationSeeder::class
        ]);
    }
}
