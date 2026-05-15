<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            [
                'series_number' => 'TYT-001',
                'name' => 'Toyota Avanza',
                'price' => 350000.00,
                'type' => 'MPV',
                'year' => '2023-01-01',
                'status' => 'Available',
                'is_electric' => false,
                'brand_id' => 1,
            ],
            [
                'series_number' => 'HND-001',
                'name' => 'Honda Civic',
                'price' => 750000.00,
                'type' => 'Sedan',
                'year' => '2022-01-01',
                'status' => 'Available',
                'is_electric' => false,
                'brand_id' => 2,
            ],
            [
                'series_number' => 'TSL-001',
                'name' => 'Tesla Model 3',
                'price' => 1500000.00,
                'type' => 'Electric',
                'year' => '2024-01-01',
                'status' => 'Available',
                'is_electric' => true,
                'brand_id' => 5,
            ],
        ];

        foreach ($cars as $car) {
            DB::table('car')->updateOrInsert(
                ['series_number' => $car['series_number']],
                $car
            );
        }
    }
}
