<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{

    public function run(): void
    {
        $rolePermissions = [
            // Super Admin Role (ID = 1)
            ['role_id' => 1, 'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],    // View Dashboard
            ['role_id' => 1, 'permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],    // Manage Dashboard
            ['role_id' => 1, 'permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],    // View Users
            ['role_id' => 1, 'permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],    // Create Users
            ['role_id' => 1, 'permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],    // Edit Users
            ['role_id' => 1, 'permission_id' => 6, 'created_at' => now(), 'updated_at' => now()],    // Delete Users
            ['role_id' => 1, 'permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],    // View Roles
            ['role_id' => 1, 'permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],    // Create Roles
            ['role_id' => 1, 'permission_id' => 9, 'created_ata' => now(), 'updated_at' => now()],    // Edit Roles
            ['role_id' => 1, 'permission_id' => 10, 'created_ata' => now(), 'updated_at' => now()],   // Delete Roles
            ['role_id' => 1, 'permission_id' => 11, 'created_ata' => now(), 'updated_at' => now()],   // View Settings
            ['role_id' => 1, 'permission_id' => 12, 'created_ata' => now(), 'updated_at' => now()],   // Manage Settings
            ['role_id' => 1, 'permission_id' => 13, 'created_ata' => now(), 'updated_at' => now()],   // View Vehicles
            ['role_id' => 1, 'permission_id' => 14, 'created_ata' => now(), 'updated_at' => now()],   // Register Vehicle
            ['role_id' => 1, 'permission_id' => 15, 'created_ata' => now(), 'updated_at' => now()],   // Edit Vehicle Details
            ['role_id' => 1, 'permission_id' => 16, 'created_ata' => now(), 'updated_at' => now()],   // Delete Vehicle
            ['role_id' => 1, 'permission_id' => 17, 'created_ata' => now(), 'updated_at' => now()],   // View Policies
            ['role_id' => 1, 'permission_id' => 18, 'created_ata' => now(), 'updated_at' => now()],   // Create Policy
            ['role_id' => 1, 'permission_id' => 19, 'created_ata' => now(), 'updated_at' => now()],   // Edit Policy
            ['role_id' => 1, 'permission_id' => 20, 'created_ata' => now(), 'updated_at' => now()],   // Delete Policy
            ['role_id' => 1, 'permission_id' => 21, 'created_ata' => now(), 'updated_at' => now()],   // View Claims
            ['role_id' => 1, 'permission_id' => 22, 'created_ata' => now(), 'updated_at' => now()],   // Process Claim
            ['role_id' => 1, 'permission_id' => 23, 'created_ata' => now(), 'updated_at' => now()],   // Approve Claim
            ['role_id' => 1, 'permission_id' => 24, 'created_ata' => now(), 'updated_at' => now()],   // Reject Claim
            ['role_id' => 1, 'permission_id' => 25, 'created_ata' => now(), 'updated_at' => now()],   // View Drivers
            ['role_id' => 1, 'permission_id' => 26, 'created_ata' => now(), 'updated_at' => now()],   // Register Driver
            ['role_id' => 1, 'permission_id' => 27, 'created_ata' => now(), 'updated_at' => now()],   // Edit Driver Details
            ['role_id' => 1, 'permission_id' => 28, 'created_ata' => now(), 'updated_at' => now()],   // Suspend Driver
            ['role_id' => 1, 'permission_id' => 29, 'created_ata' => now(), 'updated_at' => now()],   // View Reports
            ['role_id' => 1, 'permission_id' => 30, 'created_ata' => now(), 'updated_at' => now()],   // Generate Reports
            ['role_id' => 1, 'permission_id' => 31, 'created_ata' => now(), 'updated_at' => now()],   // Export Reports
            ['role_id' => 1, 'permission_id' => 32, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 33, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 34, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 35, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 36, 'created_ata' => now(), 'updated_at' => now()],    // View Dashboard
            ['role_id' => 1, 'permission_id' => 37, 'created_ata' => now(), 'updated_at' => now()],    // Manage Dashboard
            ['role_id' => 1, 'permission_id' => 38, 'created_ata' => now(), 'updated_at' => now()],    // View Users
            ['role_id' => 1, 'permission_id' => 39, 'created_ata' => now(), 'updated_at' => now()],    // Create Users
            ['role_id' => 1, 'permission_id' => 40, 'created_ata' => now(), 'updated_at' => now()],    // Edit Users
            ['role_id' => 1, 'permission_id' => 41, 'created_ata' => now(), 'updated_at' => now()],    // Delete Users
            ['role_id' => 1, 'permission_id' => 42, 'created_ata' => now(), 'updated_at' => now()],    // View Roles
            ['role_id' => 1, 'permission_id' => 43, 'created_ata' => now(), 'updated_at' => now()],    // Create Roles
            ['role_id' => 1, 'permission_id' => 44, 'created_ata' => now(), 'updated_at' => now()],    // Edit Roles
            ['role_id' => 1, 'permission_id' => 45, 'created_ata' => now(), 'updated_at' => now()],   // Delete Roles
            ['role_id' => 1, 'permission_id' => 46, 'created_ata' => now(), 'updated_at' => now()],   // View Settings
            ['role_id' => 1, 'permission_id' => 47, 'created_ata' => now(), 'updated_at' => now()],   // Manage Settings
            ['role_id' => 1, 'permission_id' => 48, 'created_ata' => now(), 'updated_at' => now()],   // View Vehicles
            ['role_id' => 1, 'permission_id' => 49, 'created_ata' => now(), 'updated_at' => now()],   // Register Vehicle
            ['role_id' => 1, 'permission_id' => 50, 'created_ata' => now(), 'updated_at' => now()],   // Edit Vehicle Details
            ['role_id' => 1, 'permission_id' => 51, 'created_ata' => now(), 'updated_at' => now()],   // Delete Vehicle
            ['role_id' => 1, 'permission_id' => 52, 'created_ata' => now(), 'updated_at' => now()],   // View Policies
            ['role_id' => 1, 'permission_id' => 53, 'created_ata' => now(), 'updated_at' => now()],   // Create Policy
            ['role_id' => 1, 'permission_id' => 54, 'created_ata' => now(), 'updated_at' => now()],   // Edit Policy
            ['role_id' => 1, 'permission_id' => 55, 'created_ata' => now(), 'updated_at' => now()],   // Delete Policy
            ['role_id' => 1, 'permission_id' => 56, 'created_ata' => now(), 'updated_at' => now()],   // View Claims
            ['role_id' => 1, 'permission_id' => 57, 'created_ata' => now(), 'updated_at' => now()],   // Process Claim
            ['role_id' => 1, 'permission_id' => 58, 'created_ata' => now(), 'updated_at' => now()],   // Approve Claim
            ['role_id' => 1, 'permission_id' => 59, 'created_ata' => now(), 'updated_at' => now()],   // Reject Claim
            ['role_id' => 1, 'permission_id' => 60, 'created_ata' => now(), 'updated_at' => now()],   // View Drivers
            ['role_id' => 1, 'permission_id' => 61, 'created_ata' => now(), 'updated_at' => now()],   // Register Driver
            ['role_id' => 1, 'permission_id' => 62, 'created_ata' => now(), 'updated_at' => now()],   // Edit Driver Details
            ['role_id' => 1, 'permission_id' => 63, 'created_ata' => now(), 'updated_at' => now()],   // Suspend Driver
            ['role_id' => 1, 'permission_id' => 64, 'created_ata' => now(), 'updated_at' => now()],   // View Reports
            ['role_id' => 1, 'permission_id' => 65, 'created_ata' => now(), 'updated_at' => now()],   // Generate Reports
            ['role_id' => 1, 'permission_id' => 66, 'created_ata' => now(), 'updated_at' => now()],   // Export Reports
            ['role_id' => 1, 'permission_id' => 67, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 68, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 69, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 71, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 72, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 70, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 73, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 74, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 75, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 76, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 77, 'created_ata' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'permission_id' => 78, 'created_ata' => now(), 'updated_at' => now()],
            // Sys Admin
            ['role_id' => 2, 'permission_id' => 1, 'created_ata' => now(), 'updated_at' => now()],    // View Dashboard
            ['role_id' => 2, 'permission_id' => 2, 'created_ata' => now(), 'updated_at' => now()],    // Manage Dashboard
            ['role_id' => 2, 'permission_id' => 3, 'created_ata' => now(), 'updated_at' => now()],    // View Users
            ['role_id' => 2, 'permission_id' => 4, 'created_ata' => now(), 'updated_at' => now()],    // Create Users
            ['role_id' => 2, 'permission_id' => 5, 'created_ata' => now(), 'updated_at' => now()],    // Edit Users
            ['role_id' => 2, 'permission_id' => 6, 'created_ata' => now(), 'updated_at' => now()],    // Delete Users
            ['role_id' => 2, 'permission_id' => 7, 'created_ata' => now(), 'updated_at' => now()],    // View Roles
            ['role_id' => 2, 'permission_id' => 8, 'created_ata' => now(), 'updated_at' => now()],    // Create Roles
            ['role_id' => 2, 'permission_id' => 9, 'created_ata' => now(), 'updated_at' => now()],    // Edit Roles
            ['role_id' => 2, 'permission_id' => 11, 'created_at' => now(), 'updated_at' => now()],   // View Settings
            ['role_id' => 2, 'permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],   // Delete Roles
            ['role_id' => 2, 'permission_id' => 12, 'created_at' => now(), 'updated_at' => now()],   // Manage Settings
            ['role_id' => 2, 'permission_id' => 13, 'created_at' => now(), 'updated_at' => now()],   // View Vehicles
            ['role_id' => 2, 'permission_id' => 14, 'created_at' => now(), 'updated_at' => now()],   // Register Vehicle
            ['role_id' => 2, 'permission_id' => 15, 'created_at' => now(), 'updated_at' => now()],   // Edit Vehicle Details
            ['role_id' => 2, 'permission_id' => 16, 'created_at' => now(), 'updated_at' => now()],   // Delete Vehicle
            ['role_id' => 2, 'permission_id' => 17, 'created_at' => now(), 'updated_at' => now()],   // View Policies
            ['role_id' => 2, 'permission_id' => 18, 'created_at' => now(), 'updated_at' => now()],   // Create Policy
            ['role_id' => 2, 'permission_id' => 19, 'created_at' => now(), 'updated_at' => now()],   // Edit Policy
            ['role_id' => 2, 'permission_id' => 20, 'created_at' => now(), 'updated_at' => now()],   // Delete Policy
            ['role_id' => 2, 'permission_id' => 21, 'created_at' => now(), 'updated_at' => now()],   // View Claims
            ['role_id' => 2, 'permission_id' => 22, 'created_at' => now(), 'updated_at' => now()],   // Process Claim
            ['role_id' => 2, 'permission_id' => 23, 'created_at' => now(), 'updated_at' => now()],   // Approve Claim
            ['role_id' => 2, 'permission_id' => 24, 'created_at' => now(), 'updated_at' => now()],   // Reject Claim
            ['role_id' => 2, 'permission_id' => 25, 'created_at' => now(), 'updated_at' => now()],   // View Drivers
            ['role_id' => 2, 'permission_id' => 26, 'created_at' => now(), 'updated_at' => now()],   // Register Driver
            ['role_id' => 2, 'permission_id' => 27, 'created_at' => now(), 'updated_at' => now()],   // Edit Driver Details
            ['role_id' => 2, 'permission_id' => 28, 'created_at' => now(), 'updated_at' => now()],   // Suspend Driver
            ['role_id' => 2, 'permission_id' => 29, 'created_at' => now(), 'updated_at' => now()],   // View Reports
            ['role_id' => 2, 'permission_id' => 30, 'created_at' => now(), 'updated_at' => now()],   // Generate Reports
            ['role_id' => 2, 'permission_id' => 31, 'created_at' => now(), 'updated_at' => now()],


            // Platform Administrator Role (ID = 2)
            ['role_id' => 3, 'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],    // View Dashboard
            ['role_id' => 3, 'permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],    // Manage Dashboard
            ['role_id' => 3, 'permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],    // View Users
            ['role_id' => 3, 'permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],    // Create Users
            ['role_id' => 3, 'permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],    // Edit Users
            ['role_id' => 3, 'permission_id' => 6, 'created_at' => now(), 'updated_at' => now()],    // Delete Users
            ['role_id' => 3, 'permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],    // View Roles
            ['role_id' => 3, 'permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],    // Create Roles
            ['role_id' => 3, 'permission_id' => 9, 'created_at' => now(), 'updated_at' => now()],    // Edit Roles
            ['role_id' => 3, 'permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],   // Delete Roles

            // Department Manager Role (ID = 3)
            ['role_id' => 4, 'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],    // View Dashboard
            ['role_id' => 4, 'permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],    // View Users
            ['role_id' => 4, 'permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],    // Create Users
            ['role_id' => 4, 'permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],    // Edit Users
            ['role_id' => 4, 'permission_id' => 6, 'created_at' => now(), 'updated_at' => now()],    // Delete Users
            ['role_id' => 4, 'permission_id' => 32, 'created_at' => now(), 'updated_at' => now()],   // View Users
            ['role_id' => 4, 'permission_id' => 33, 'created_at' => now(), 'updated_at' => now()],   // Create Users

            // Content Manager Role (ID = 4)
            ['role_id' => 5, 'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],    // View Dashboard
            ['role_id' => 5, 'permission_id' => 32, 'created_at' => now(), 'updated_at' => now()],   // View Users
            ['role_id' => 5, 'permission_id' => 33, 'created_at' => now(), 'updated_at' => now()],   // Create Users

            // Registered User Role (ID = 6)
            ['role_id' => 6, 'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],    // View Dashboard
            ['role_id' => 6, 'permission_id' => 30, 'created_at' => now(), 'updated_at' => now()],   // View Profile

            // Guest User Role (ID = 7)
            ['role_id' => 7, 'permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],    // View Dashboard
            ['role_id' => 7, 'permission_id' => 30, 'created_at' => now(), 'updated_at' => now()],   // View Content
        ];

        // Insert permissions for all roles
        DB::table('role_permissions')->insert($rolePermissions);
    }
}
