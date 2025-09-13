<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RfidScannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define common scanner manufacturers and models
        $manufacturers = [
            'Zebra' => ['FX9600', 'FX7500', 'RFD8500', 'MC3330R'],
            'Honeywell' => ['IF2B', 'IF30', 'IH25', 'IH40'],
            'Impinj' => ['R700', 'R510', 'R420', 'xPortal'],
            'Alien Technology' => ['ALR-F800', 'ALR-H450', 'ALR-9680', 'ALR-9650'],
            'ThingMagic' => ['M6e', 'M6e-Nano', 'Sargas', 'Astra-EX']
        ];

        // Define common firmware versions
        $firmwareVersions = [
            '1.0.5',
            '1.2.3',
            '2.0.1',
            '2.1.0',
            '3.0.4',
            '3.2.1',
            '4.0.0-beta'
        ];

        // Define possible locations
        $locations = [
            'Main Entrance',
            'Exit Gate',
            'Warehouse A',
            'Warehouse B',
            'Loading Dock 1',
            'Loading Dock 2',
            'Security Checkpoint',
            'Parking Lot North',
            'Parking Lot South',
            'Building 1 Entrance',
            'Building 2 Entrance',
            'Conference Room',
            'IT Department',
            'Administration Office',
            'Vehicle Processing Center'
        ];

        // Define sample JSON settings
        $settingsTemplates = [
            json_encode([
                'read_power' => 30,
                'write_power' => 25,
                'session' => 1,
                'search_mode' => 'dual_target',
                'tag_population' => 'dense',
                'scan_interval' => 500
            ]),
            json_encode([
                'read_power' => 27,
                'write_power' => 22,
                'session' => 2,
                'search_mode' => 'single_target',
                'tag_population' => 'sparse',
                'scan_interval' => 1000
            ]),
            json_encode([
                'read_power' => 32,
                'write_power' => 28,
                'session' => 0,
                'search_mode' => 'dual_target',
                'tag_population' => 'medium',
                'beep_on_read' => true,
                'scan_interval' => 750
            ]),
            json_encode([
                'read_power' => 25,
                'write_power' => 20,
                'session' => 1,
                'search_mode' => 'single_target',
                'tag_population' => 'dense',
                'auto_sleep' => true,
                'scan_interval' => 250
            ])
        ];

        // Generate 25 scanners
        $scanners = [];
        $now = Carbon::now();

        for ($i = 1; $i <= 25; $i++) {
            // Select a random manufacturer and model
            $manufacturer = array_rand($manufacturers);
            $model = $manufacturers[$manufacturer][array_rand($manufacturers[$manufacturer])];

            // Generate a serial number
            $serialNumber = strtoupper(substr($manufacturer, 0, 3)) . '-' . substr($model, 0, 3) . '-' . Str::random(8);

            // Generate an IP address
            $ipAddress = '192.168.' . rand(1, 254) . '.' . rand(1, 254);

            // Generate a MAC address
            $macAddress = implode(':', array_map(function () {
                return sprintf('%02X', rand(0, 255));
            }, range(1, 6)));

            // Determine if the scanner is active
            $isActive = rand(0, 100) < 90; // 90% chance of being active

            // Set dates
            $createdAt = $now->copy()->subDays(rand(30, 365));
            $lastOnlineAt = $isActive ? $now->copy()->subMinutes(rand(0, 1440)) : $now->copy()->subDays(rand(5, 30));
            $lastMaintenanceAt = $now->copy()->subDays(rand(0, 90));

            // Random notes
            $noteOptions = [
                'Installed by tech team on ' . $createdAt->format('Y-m-d'),
                'Requires firmware update',
                'Experiencing intermittent connectivity issues',
                'High-traffic location, may need power adjustment',
                'Replaced power adapter on ' . $lastMaintenanceAt->format('Y-m-d'),
                'Antenna connection checked during last maintenance',
                null
            ];

            $scanners[] = [
                'serial_number' => $serialNumber,
                'model' => $model,
                'manufacturer' => $manufacturer,
                'location' => $locations[array_rand($locations)],
                'ip_address' => $ipAddress,
                'mac_address' => $macAddress,
                // 'firmware_version' => $firmwareVersions[array_rand($firmwareVersions)],
                'is_active' => $isActive,
                'settings' => $settingsTemplates[array_rand($settingsTemplates)],
                'last_online_at' => $isActive ? $lastOnlineAt : null,
                'last_maintenance_at' => $lastMaintenanceAt,
                'notes' => $noteOptions[array_rand($noteOptions)],
                'created_at' => $createdAt,
                'updated_at' => $now
            ];
        }

        // Insert all scanners
        DB::table('rfid_scanners')->insert($scanners);
    }
}
