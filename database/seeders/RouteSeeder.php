<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $routeTypes = DB::table('route_types')->pluck('id', 'route_type_name');

        DB::table('routes')->insert([
        //$routes = [
            [
                'route_type_id' => $routeTypes['Inter Provincial'],
                'route_name' => 'Lae to Goroka via Highlands Highway',
                'created_at' => now(),
                'updated_at' => now()
                //'route_type_id' => 1, // Assuming Highlands Highway is the first route type
            ],
            [
                'route_type_id' => $routeTypes['Intra Provincial'],
                'route_name' => 'Kavieng to Namatanai via Boluminski Highway',
                'created_at' => now(),
                'updated_at' => now()
                //'route_type_id' => 2, // Assuming Boluminski Highway is the second route type
            ],
            [
                'route_type_id' => $routeTypes['Inter Provincial'],
                'route_name' => 'Kiunga to Tabubil via Kiunga-Tabubil Highway',
                'created_at' => now(),
                'updated_at' => now()
                //'route_type_id' => 1, // Assuming Kiunga-Tabubil Highway is the third route type
            ],
            [
                'route_type_id' => $routeTypes['Inter Provincial'],
                'route_name' => 'Watarais to Madang via Ramu Highway',
                'created_at' => now(),
                'updated_at' => now()
                //'route_type_id' => 1, // Assuming Ramu Highway is the fourth route type
            ],
            [
                'route_type_id' => $routeTypes['Inter Provincial'],
                'route_name' => 'Gulf Province to Southern Highlands via Gulf-to-Southern Highlands Highway',
                'created_at' => now(),
                'updated_at' => now()
                //'route_type_id' => 1, // Assuming Gulf-to-Southern Highlands Highway is the fifth route type
            ],
            [
                'route_type_id' => $routeTypes['Intra Provincial'],
                'route_name' => 'Wau to Bulolo via Sepik Coastal Highway',
                'created_at' => now(),
                'updated_at' => now()
                //'route_type_id' => 2, // Assuming Sepik Coastal Highway is the sixth route type
            ],
            [
                'route_type_id' => $routeTypes['Intra Provincial'],
                'route_name' => 'Hoskins to Kimbe via Magi Highway',
                'created_at' => now(),
                'updated_at' => now()
                //'route_type_id' => 2, // Assuming Magi Highway is the seventh route type
            ],
            [
                'route_type_id' => $routeTypes['Intra Provincial'],
                'route_name' => 'Tari to Pori via Bougainville Road',
                'created_at' => now(),
                'updated_at' => now()
                //'route_type_id' => 2, // Assuming Bougainville Road is the eighth route type
            ],
            // Add more routes as needed
        ]);


        //DB::table('routes')->insert($routes);
    }
}
