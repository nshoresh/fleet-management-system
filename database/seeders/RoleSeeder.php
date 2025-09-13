<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'role_group' => 'System',
                'description' => 'Full system access with all permissions for managing the entire platform',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'System Admin',
                'role_group' => 'System',
                'description' => 'Full system access with all permissions for managing the entire platform',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Platform Administrator',
                'role_group' => 'System',
                'description' => 'Administrator with elevated access to configure settings and manage users',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Site Manager',
                'role_group' => 'Client',
                'description' => 'Manager with the ability to oversee specific Sites or Business and manage teams',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Fleet Manager',
                'role_group' => 'Client',
                'description' => 'Oversees fleet operations, vehicle tracking, and maintenance management, billings and billings',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Billing Manager',
                'role_group' => 'Client',
                'description' => 'Responsible for handling invoicing, payments, and financial records',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Clients Manager',
                'role_group' => 'Client',
                'description' => 'Manages client relationships, contracts, and service agreements',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Logistics Coordinator',
                'role_group' => 'Client',
                'slug' => 'logistics-coordinator',
                'description' => 'Coordinates vehicle dispatch, route planning, and deliveries',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Driver',
                'role_group' => 'Client',
                'description' => 'Assigned to fleet vehicles, responsible for transportation and tracking compliance',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Maintenance Manager',
                'role_group' => 'Client',
                'description' => 'Oversees vehicle repairs, inspections, and maintenance schedules',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Dispatcher',
                'role_group' => 'Client',
                'description' => 'Handles fleet dispatching, real-time tracking, and communication with drivers',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Content Manager',
                'role_group' => 'System',
                'description' => 'Responsible for managing content and ensuring its quality before publication',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Content Contributor',
                'role_group' => 'System',
                'description' => 'Creators of content who have the ability to submit but not publish content directly',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Registered User',
                'role_group' => 'Client',
                'description' => 'Users with access to basic features of the system',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Guest User',
                'role_group' => 'Client',
                'description' => 'Temporary access with limited permissions for new or unregistered users',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role['name'],
                // 'slug' => $role['slug'] ?? Str::slug($role['name']),
                'role_group' => $role['role_group'],
                'description' => $role['description'],
                'is_active' => $role['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
