<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LicenseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $licenseTypes = [
            [
                'type_name' => 'Standard',
                'type_description' => 'Standard license type for regular operations.',
                'type_category' => 'Commercial',
                'is_active' => true,
            ],
            [
                'type_name' => 'Temporary',
                'type_description' => 'Temporary license for short-term operations.',
                'type_category' => 'Special',
                'is_active' => true,
            ],
        ];

        // Insert data into license_types table
        DB::table('license_types')
            ->insert($licenseTypes);
    }
}
