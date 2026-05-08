<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Dominic',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'call_number' => '081234567890',
                'role_id' => 1,
                'status' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Employee Rentidy',
                'email' => 'employee@example.com',
                'password' => Hash::make('employee123'),
                'call_number' => '081234567891',
                'role_id' => 2,
                'status' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Evelyn Customer',
                'email' => 'customer@example.com',
                'password' => Hash::make('customer123'),
                'call_number' => '081234567892',
                'role_id' => 3,
                'status' => 1,
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['id' => $user['id']],
                array_merge($user, [
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
