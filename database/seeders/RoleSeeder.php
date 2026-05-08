<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'name' => 'admin'],
            ['id' => 2, 'name' => 'employee'],
            ['id' => 3, 'name' => 'customer'],
        ];

        foreach ($roles as $role) {
            DB::table('role')->updateOrInsert(
                ['id' => $role['id']],
                ['name' => $role['name']]
            );
        }
    }
}
