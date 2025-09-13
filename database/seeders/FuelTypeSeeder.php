<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FuelType;

class FuelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Petrol', 'Diesel', 'Electric', 'Hybrid'];
        foreach ($types as $type) {
            FuelType::firstOrCreate(['name' => $type]);
        }
    }
}
