<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VehicleColor;

class VehicleColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = ['Red', 'Blue', 'Black', 'White', 'Silver', 'Green'];
        foreach ($colors as $color) {
            VehicleColor::firstOrCreate(['name' => $color]);
        }
    }
}
