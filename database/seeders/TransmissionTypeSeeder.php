<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransmissionType;

class TransmissionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Manual', 'Automatic', 'Semi-Automatic'];
        foreach ($types as $type) {
            TransmissionType::firstOrCreate(['name' => $type]);
        }
    }
}
