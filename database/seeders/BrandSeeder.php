<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Toyota'],
            ['name' => 'Honda'],
            ['name' => 'Suzuki'],
            ['name' => 'Mitsubishi'],
            ['name' => 'Tesla'],
        ];

        foreach ($brands as $brand) {
            DB::table('brand')->updateOrInsert(
                ['name' => $brand['name']],
                $brand
            );
        }
    }
}
