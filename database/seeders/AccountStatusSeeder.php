<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'status' => 'Active',
                'description' => 'Account is fully active and operational.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status' => 'Inactive',
                'description' => 'Account is temporarily inactive.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status' => 'Disabled',
                'description' => 'Account has been permanently disabled.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'status' => 'Locked',
                'description' => 'Account is locked due to security reasons.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($statuses as $status) {
            DB::table('account_statuses')->updateOrInsert(
                ['status' => $status['status']],  // Check for existing 'status'
                $status  // If not exists, insert this status
            );
        }
    }
}
