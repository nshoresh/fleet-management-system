<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regions')->insert([
            [
                'name' => 'Highlands Region',
                'code' => 'HL',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Momase Region',
                'code' => 'MM',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Southern Region',
                'code' => 'SR',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'New Guinea Islands Region',
                'code' => 'NGI',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
