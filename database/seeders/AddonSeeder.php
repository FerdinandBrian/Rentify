<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddonSeeder extends Seeder
{
    public function run(): void
    {
        $addons = [
            [
                'name' => 'GPS',
                'price_per_unit' => 50000.00,
                'price_per_day' => null,
            ],
            [
                'name' => 'Baby Seat',
                'price_per_unit' => 150000.00,
                'price_per_day' => null,
            ],
            [
                'name' => 'Insurance',
                'price_per_unit' => 150000.00,
                'price_per_day' => null,
            ],
            [
                'name' => 'Driver',
                'price_per_unit' => null,
                'price_per_day' => 150000.00,
            ],
        ];

        foreach ($addons as $addon) {
            DB::table('addon')->updateOrInsert(
                ['name' => $addon['name']],
                $addon
            );
        }
    }
}
