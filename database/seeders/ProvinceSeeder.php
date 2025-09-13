<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = DB::table('regions')->pluck('id', 'name');

        DB::table('provinces')->insert([
            // Highlands Region
            [
                'name' => 'Eastern Highlands',
                'code' => 'EHP',
                'region_id' => $regions['Highlands Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Western Highlands',
                'code' => 'WHP',
                'region_id' => $regions['Highlands Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Simbu',
                'code' => 'SIM',
                'region_id' => $regions['Highlands Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Enga',
                'code' => 'EP',
                'region_id' => $regions['Highlands Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Hela',
                'code' => 'HEP',
                'region_id' => $regions['Highlands Region'],
                'created_at' => now(),
                'updated_at' => now()

            ],
            [
                'name' => 'Jiwaka',
                'code' => 'JWP',
                'region_id' => $regions['Highlands Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Southern Highlands',
                'code' => 'SHP',
                'region_id' => $regions['Highlands Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],


            // Momase Region
            [
                'name' => 'Morobe',
                'code' => 'MP',
                'region_id' => $regions['Momase Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Madang',
                'code' => 'MDP',
                'region_id' => $regions['Momase Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'East Sepik',
                'code' => 'ESP',
                'region_id' => $regions['Momase Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'West Sepik (Sandaun)',
                'code' => 'WSP',
                'region_id' => $regions['Momase Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Southern Region
            [
                'name' => 'Central',
                'code' => 'CP',
                'region_id' => $regions['Southern Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Gulf',
                'code' => 'GP',
                'region_id' => $regions['Southern Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Milne Bay',
                'code' => 'MBP',
                'region_id' => $regions['Southern Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Western (Fly)',
                'code' => 'WP',
                'region_id' => $regions['Southern Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'National Capital District',
                'code' => 'NCD',
                'region_id' => $regions['Southern Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],

            // New Guinea Islands Region
            [
                'name' => 'East New Britain',
                'code' => 'ENBP',
                'region_id' => $regions['New Guinea Islands Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'West New Britain',
                'code' => 'WNBP',
                'region_id' => $regions['New Guinea Islands Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Manus',
                'code' => 'MNP',
                'region_id' => $regions['New Guinea Islands Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'New Ireland',
                'code' => 'NIP',
                'region_id' => $regions['New Guinea Islands Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bougainville (Autonomous Region)',
                'code' => 'AROB',
                'region_id' => $regions['New Guinea Islands Region'],
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
