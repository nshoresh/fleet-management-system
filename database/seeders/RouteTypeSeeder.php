<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('route_types')->insert(
            [
                // Highlands Region Routes
                ['route_type_name' => 'Inter Provincial'],
                ['route_type_name' => 'Intra Provincial']
            ]
        );
    }
}
