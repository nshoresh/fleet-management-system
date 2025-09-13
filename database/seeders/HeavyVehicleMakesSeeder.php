<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HeavyVehicleMakesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleMakes = [
            // Trucks and Commercial Vehicles
            ['name' => 'Volvo Trucks', 'country' => 'Sweden', 'description' => 'Manufacturer of heavy-duty trucks and commercial vehicles.'],
            ['name' => 'Scania', 'country' => 'Sweden', 'description' => 'Premium heavy-duty trucks and buses manufacturer.'],
            ['name' => 'Mercedes-Benz Trucks', 'country' => 'Germany', 'description' => 'Commercial division of Mercedes-Benz, producing trucks and special vehicles.'],
            ['name' => 'MAN Truck & Bus', 'country' => 'Germany', 'description' => 'Manufacturer of commercial vehicles and diesel engines.'],
            ['name' => 'DAF Trucks', 'country' => 'Netherlands', 'description' => 'Commercial vehicle manufacturing company.'],
            ['name' => 'Iveco', 'country' => 'Italy', 'description' => 'Industrial vehicles manufacturer that produces light, medium and heavy commercial vehicles.'],
            ['name' => 'Kenworth', 'country' => 'USA', 'description' => 'Manufacturer of medium and heavy-duty Class 8 trucks.'],
            ['name' => 'Peterbilt', 'country' => 'USA', 'description' => 'American manufacturer of medium- and heavy-duty trucks.'],
            ['name' => 'Freightliner', 'country' => 'USA', 'description' => 'Manufacturer of heavy-duty trucks, part of Daimler Trucks North America.'],
            ['name' => 'Mack Trucks', 'country' => 'USA', 'description' => 'Manufacturer of heavy-duty trucks.'],
            ['name' => 'International Trucks', 'country' => 'USA', 'description' => 'Manufacturer of commercial trucks, buses and diesel engines.'],
            ['name' => 'Western Star', 'country' => 'USA', 'description' => 'American manufacturer of heavy-duty trucks.'],
            ['name' => 'Hino', 'country' => 'Japan', 'description' => 'Toyota Group company manufacturing commercial vehicles and diesel engines.'],
            ['name' => 'Isuzu', 'country' => 'Japan', 'description' => 'Manufacturer of commercial vehicles and diesel engines.'],
            ['name' => 'Fuso', 'country' => 'Japan', 'description' => 'Manufacturer of trucks and buses, now part of Daimler Trucks.'],
            ['name' => 'UD Trucks', 'country' => 'Japan', 'description' => 'Manufacturer of trucks and buses, formerly known as Nissan Diesel.'],
            ['name' => 'Tata Motors', 'country' => 'India', 'description' => 'Manufacturer of commercial and passenger vehicles.'],
            ['name' => 'Ashok Leyland', 'country' => 'India', 'description' => 'Indian automobile company, manufacturer of commercial vehicles.'],
            ['name' => 'Dongfeng', 'country' => 'China', 'description' => 'Chinese state-owned automobile manufacturer.'],
            ['name' => 'FAW', 'country' => 'China', 'description' => 'Chinese state-owned automotive manufacturing company.'],
            ['name' => 'SINOTRUK', 'country' => 'China', 'description' => 'Chinese state-owned truck manufacturer.'],
            ['name' => 'GAZ Group', 'country' => 'Russia', 'description' => 'Russian automotive manufacturer producing commercial vehicles.'],
            ['name' => 'KAMAZ', 'country' => 'Russia', 'description' => 'Russian manufacturer of trucks and engines.'],
            ['name' => 'PACCAR', 'country' => 'USA', 'description' => 'Parent company of Kenworth, Peterbilt and DAF Trucks.'],
            ['name' => 'Navistar', 'country' => 'USA', 'description' => 'Manufacturer of commercial trucks, buses, and diesel engines.'],

            // Bus Manufacturers
            ['name' => 'Alexander Dennis', 'country' => 'UK', 'description' => 'British bus manufacturing company.'],
            ['name' => 'Van Hool', 'country' => 'Belgium', 'description' => 'Belgian manufacturer of buses, coaches and industrial vehicles.'],
            ['name' => 'VDL Bus & Coach', 'country' => 'Netherlands', 'description' => 'Dutch manufacturer of buses and coaches.'],
            ['name' => 'Solaris Bus & Coach', 'country' => 'Poland', 'description' => 'Polish producer of public transport vehicles.'],
            ['name' => 'New Flyer', 'country' => 'Canada', 'description' => 'Canadian manufacturer of heavy-duty transit buses.'],
            ['name' => 'Blue Bird Corporation', 'country' => 'USA', 'description' => 'American manufacturer of school and activity buses.'],
            ['name' => 'Prevost', 'country' => 'Canada', 'description' => 'Manufacturer of premium touring and commuter coaches.'],
            ['name' => 'Irizar', 'country' => 'Spain', 'description' => 'Spanish manufacturer of luxury coach and bus bodywork.'],
            ['name' => 'Yutong', 'country' => 'China', 'description' => 'Chinese manufacturer of commercial vehicles, especially electric buses.'],
            ['name' => 'BYD', 'country' => 'China', 'description' => 'Chinese manufacturer specializing in electric vehicles including buses.'],
            ['name' => 'TATA Marcopolo', 'country' => 'India', 'description' => 'Indian bus and coach manufacturer.'],

            // Construction Equipment
            ['name' => 'Caterpillar', 'country' => 'USA', 'description' => 'American corporation that designs, develops, manufactures, and sells machinery and engines.'],
            ['name' => 'Komatsu', 'country' => 'Japan', 'description' => 'Japanese multinational corporation that manufactures construction and mining equipment.'],
            ['name' => 'Hitachi Construction Machinery', 'country' => 'Japan', 'description' => 'Manufactures construction equipment, including excavators and mining equipment.'],
            ['name' => 'Liebherr', 'country' => 'Switzerland', 'description' => 'Swiss construction machinery and mining equipment manufacturer.'],
            ['name' => 'JCB', 'country' => 'UK', 'description' => 'Manufacturer of equipment for construction, agriculture, and defense.'],
            ['name' => 'Volvo Construction Equipment', 'country' => 'Sweden', 'description' => 'Manufactures construction equipment, including articulated haulers, excavators, and wheel loaders.'],
            ['name' => 'XCMG', 'country' => 'China', 'description' => 'Chinese multinational state-owned heavy machinery manufacturing company.'],
            ['name' => 'SANY', 'country' => 'China', 'description' => 'Chinese multinational heavy equipment manufacturing company.'],
            ['name' => 'Doosan Infracore', 'country' => 'South Korea', 'description' => 'Manufacturer of construction equipment, engines, and machinery.'],
            ['name' => 'Terex', 'country' => 'USA', 'description' => 'American manufacturer of lifting and material handling equipment.'],
            ['name' => 'Bell Equipment', 'country' => 'South Africa', 'description' => 'Manufactures articulated dump trucks and various loading equipment.'],
            ['name' => 'Bobcat', 'country' => 'USA', 'description' => 'Manufactures farm and construction equipment, especially skid-steer loaders.'],
            ['name' => 'CNH Industrial', 'country' => 'UK/Italy', 'description' => 'Manufactures agricultural and construction equipment.'],
            ['name' => 'Kobelco', 'country' => 'Japan', 'description' => 'Japanese manufacturer of excavators and cranes.'],
            ['name' => 'Kubota', 'country' => 'Japan', 'description' => 'Manufactures tractors and heavy equipment for construction and agriculture.'],

            // Agricultural Equipment
            ['name' => 'John Deere', 'country' => 'USA', 'description' => 'Manufactures agricultural, construction, and forestry machinery.'],
            ['name' => 'Case IH', 'country' => 'USA', 'description' => 'Manufactures agricultural equipment, part of CNH Industrial.'],
            ['name' => 'New Holland', 'country' => 'Italy', 'description' => 'Manufactures agricultural machinery, part of CNH Industrial.'],
            ['name' => 'AGCO', 'country' => 'USA', 'description' => 'Agricultural equipment manufacturer, includes brands like Massey Ferguson and Fendt.'],
            ['name' => 'Massey Ferguson', 'country' => 'USA', 'description' => 'Manufactures agricultural equipment, owned by AGCO.'],
            ['name' => 'Fendt', 'country' => 'Germany', 'description' => 'Manufactures agricultural tractors and equipment, owned by AGCO.'],
            ['name' => 'Claas', 'country' => 'Germany', 'description' => 'Manufactures agricultural machinery.'],
            ['name' => 'Deutz-Fahr', 'country' => 'Germany', 'description' => 'Manufactures tractors and other agricultural equipment.'],
            ['name' => 'Mahindra & Mahindra', 'country' => 'India', 'description' => 'Manufactures tractors and farm equipment.'],
            ['name' => 'Zetor', 'country' => 'Czech Republic', 'description' => 'Manufacturer of agricultural tractors.'],

            // Specialty and Other Heavy Vehicles
            ['name' => 'Oshkosh', 'country' => 'USA', 'description' => 'Designs and builds specialty trucks, military vehicles, and airport fire equipment.'],
            ['name' => 'BAE Systems', 'country' => 'UK', 'description' => 'Manufactures military vehicles and defense equipment.'],
            ['name' => 'Rosenbauer', 'country' => 'Austria', 'description' => 'Manufactures firefighting equipment and vehicles.'],
            ['name' => 'Manitowoc', 'country' => 'USA', 'description' => 'Manufactures cranes and lifting solutions.'],
            ['name' => 'Tadano', 'country' => 'Japan', 'description' => 'Manufactures cranes and aerial work platforms.'],
            ['name' => 'Hyster-Yale', 'country' => 'USA', 'description' => 'Manufactures forklift trucks and warehousing equipment.'],
            ['name' => 'Toyota Material Handling', 'country' => 'Japan', 'description' => 'Manufactures forklifts and material handling equipment.'],
            ['name' => 'Kalmar', 'country' => 'Finland', 'description' => 'Manufactures cargo handling equipment and services for ports.'],
            ['name' => 'Grove', 'country' => 'USA', 'description' => 'Manufactures mobile hydraulic cranes, part of Manitowoc.'],
            ['name' => 'Nikola Corporation', 'country' => 'USA', 'description' => 'Designs and manufactures hydrogen-electric vehicles and energy solutions.'],
            ['name' => 'Tesla Semi', 'country' => 'USA', 'description' => 'Electric semi-truck manufacturer, division of Tesla, Inc.'],
            ['name' => 'Rivian', 'country' => 'USA', 'description' => 'Electric vehicle manufacturer developing commercial vans and trucks.'],
            ['name' => 'Renault Trucks', 'country' => 'France', 'description' => 'French commercial truck manufacturer, part of the Volvo Group.'],
            ['name' => 'Hyundai Commercial Vehicles', 'country' => 'South Korea', 'description' => 'Manufacturer of trucks and commercial vehicles.'],
            ['name' => 'SML Isuzu', 'country' => 'India', 'description' => 'Indian manufacturer of light and medium commercial vehicles.'],
            ['name' => 'Force Motors', 'country' => 'India', 'description' => 'Indian manufacturer of multi-utility and cross country vehicles.'],
            ['name' => 'Eicher Motors', 'country' => 'India', 'description' => 'Indian manufacturer of trucks and buses.'],
            ['name' => 'BEML', 'country' => 'India', 'description' => 'Indian public sector company manufacturing construction and mining equipment.'],
            ['name' => 'Rheinmetall MAN Military Vehicles', 'country' => 'Germany', 'description' => 'Manufactures military trucks and vehicles.'],
            ['name' => 'Otokar', 'country' => 'Turkey', 'description' => 'Turkish manufacturer of buses and military vehicles.'],
            ['name' => 'Daewoo Trucks', 'country' => 'South Korea', 'description' => 'Manufacturer of commercial vehicles.'],
            ['name' => 'URO', 'country' => 'Spain', 'description' => 'Spanish manufacturer of all-terrain military vehicles.'],
            ['name' => 'KrAZ', 'country' => 'Ukraine', 'description' => 'Ukrainian manufacturer of trucks and special purpose vehicles.'],
            ['name' => 'TATRA', 'country' => 'Czech Republic', 'description' => 'Czech manufacturer of heavy-duty off-road trucks and vehicles.']
        ];

        $now = Carbon::now();

        foreach ($vehicleMakes as $make) {
            DB::table('vehicle_makes')->insert([
                'name' => $make['name'],
                'country' => $make['country'],
                'description' => $make['description'],
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
