<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Admin1',
                'email' => 'admin1@example.com',
                'password' => bcrypt('admin123'),
                'call_number' => '1234567890',
                'role_id' => 1,
            ],
            [
                'name' => 'Admin2',
                'email' => 'admin2@example.com',
                'password' => bcrypt('admin123'),
                'call_number' => '1234567890',
                'role_id' => 1,
            ],
            [
                'name' => 'Admin3',
                'email' => 'admin3@example.com',
                'password' => bcrypt('admin123'),
                'call_number' => '1234567890',
                'role_id' => 1,
            ],
            [
                'name' => 'Admin4',
                'email' => 'admin4@example.com',
                'password' => bcrypt('admin123'),
                'call_number' => '1234567890',
                'role_id' => 1,
            ],
            [
                'name' => 'Admin5',
                'email' => 'admin5@example.com',
                'password' => bcrypt('admin123'),
                'call_number' => '1234567890',
                'role_id' => 1,
            ],
            [
                'name' => 'Admin6',
                'email' => 'admin6@example.com',
                'password' => bcrypt('admin123'),
                'call_number' => '1234567890',
                'role_id' => 1,
            ],
            [
                'name' => 'Admin7',
                'email' => 'admin7@example.com',
                'password' => bcrypt('admin123'),
                'call_number' => '1234567890',
                'role_id' => 1,
            ],
            [
                'name' => 'Admin8',
                'email' => 'admin8@example.com',
                'password' => bcrypt('admin123'),
                'call_number' => '1234567890',
                'role_id' => 1,
            ],
            [
                'name' => 'Admin9',
                'email' => 'admin9@example.com',
                'password' => bcrypt('admin123'),
                'call_number' => '1234567890',
                'role_id' => 1,
            ],
            [
                'name' => 'Admin10',
                'email' => 'admin10@example.com',
                'password' => bcrypt('admin123'),
                'call_number' => '1234567890',
                'role_id' => 1,
            ],
            [
                'name' => 'Employee',
                'email' => 'employee@example.com',
                'password' => bcrypt('employee123'),
                'call_number' => '1234567891',
                'role_id' => 2,
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@example.com',
                'password' => bcrypt('customer123'),
                'call_number' => '1234567892',
                'role_id' => 3,
            ]
        ];

        foreach ($user as $user) {
            DB::table('users')->updateOrInsert(
                ['name' => $user['name']],
                [
                    'email' => $user['email'],
                    'password' => $user['password'],
                    'role_id' => $user['role_id'],
                    'call_number' => $user['call_number'],
                ]
            );
        }
    }
}