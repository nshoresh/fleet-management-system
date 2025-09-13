<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                // 'uuid' => User::generateUniqueUuid(),
                'name' => 'Super Admin',
                'email' => 'superadmin@yumicode.tech',
                'phone' => '1234567890',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'), // Use secure password
                'role_id' => 1, // Assuming 1 is Super Admin in roles table
                'account_status_id' => 1, // Assuming 1 is Active in account_statuses table
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'user_type_id' => 1
            ],
            [
                // 'uuid' => User::generateUniqueUuid(),
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'phone' => '0987654321',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role_id' => 2, // Assuming 2 is Administrator in roles table
                'account_status_id' => 1, // Active
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'user_type_id' => 1
            ],
            [
                // 'uuid' => User::generateUniqueUuid(),
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'phone' => '1122334455',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role_id' => 3, // Assuming 3 is Manager
                'account_status_id' => 2, // Inactive
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'user_type_id' => 2
            ],
            [
                // 'uuid' => User::generateUniqueUuid(),
                'name' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'phone' => '2233445566',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role_id' => 4, // Editor
                'account_status_id' => 1, // Active
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'user_type_id' => 2
            ],
            [
                // 'uuid' => User::generateUniqueUuid(),
                'name' => 'Guest User',
                'email' => 'guest@example.com',
                'phone' => '6677889900',
                'email_verified_at' => null, // Not verified
                'password' => Hash::make('password123'),
                'role_id' => 6, // Guest
                'account_status_id' => 3, // Disabled
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'user_type_id' => 2
            ]
        ];
        // Create each user individually
        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}
