<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_types')->insert([
            [
                'type_name' => 'System User',
                'slug' => Str::slug('System User'),
                'description' => 'Users with administrative access to the system.',
                'access_code' => '10000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type_name' => 'Client User',
                'slug' => Str::slug('Client User'),
                'description' => 'Users who interact with the system as clients.',
                'access_code' => '100001',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
