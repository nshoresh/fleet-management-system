<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LicensePurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $licensePurposes = [
            [
                'purpose_name' => 'Heavy Goods',
                'purpose_description' => 'License for transporting heavy goods.',
                'purpose_category' => 'Transportation', // Matches ENUM options
                'is_active' => true,
            ],
            [
                'purpose_name' => 'Road Damage Charges',
                'purpose_description' => 'License related to road damage charges.',
                'purpose_category' => 'Special', // Matches ENUM options
                'is_active' => true,
            ],
            [
                'purpose_name' => 'Transportation Goods',
                'purpose_description' => 'License for transporting goods.',
                'purpose_category' => 'Transportation', // Matches ENUM options
                'is_active' => true,
            ],
            [
                'purpose_name' => 'Transportation Passengers',
                'purpose_description' => 'License for transporting passengers.',
                'purpose_category' => 'Transportation', // Matches ENUM options
                'is_active' => true,
            ],
        ];

        DB::table('license_purposes')
            ->insert($licensePurposes);
    }
}
