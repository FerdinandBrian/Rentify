<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $brands = DB::table('brand')->pluck('id', 'name');

        $cars = [
            ['series_number' => 'TYT-001', 'name' => 'Toyota Avanza', 'price' => 350000, 'type' => 'MPV', 'year' => '2023-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Toyota']],
            ['series_number' => 'TYT-002', 'name' => 'Toyota Innova', 'price' => 500000, 'type' => 'MPV', 'year' => '2023-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Toyota']],
            ['series_number' => 'TYT-003', 'name' => 'Toyota Agya', 'price' => 250000, 'type' => 'City Car', 'year' => '2023-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Toyota']],
            ['series_number' => 'TYT-004', 'name' => 'Toyota Yaris', 'price' => 375000, 'type' => 'Hatchback', 'year' => '2020-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Toyota']],
            ['series_number' => 'TYT-005', 'name' => 'Toyota Calya', 'price' => 300000, 'type' => 'MPV', 'year' => '2022-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Toyota']],
            ['series_number' => 'DAI-001', 'name' => 'Daihatsu Xenia', 'price' => 320000, 'type' => 'MPV', 'year' => '2022-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Daihatsu']],
            ['series_number' => 'DAI-002', 'name' => 'Daihatsu Ayla', 'price' => 250000, 'type' => 'City Car', 'year' => '2022-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Daihatsu']],
            ['series_number' => 'DAI-003', 'name' => 'Daihatsu Sigra', 'price' => 280000, 'type' => 'MPV', 'year' => '2022-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Daihatsu']],
            ['series_number' => 'HND-001', 'name' => 'Honda Civic', 'price' => 750000, 'type' => 'Sedan', 'year' => '2022-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Honda']],
            ['series_number' => 'HND-002', 'name' => 'Honda Brio', 'price' => 275000, 'type' => 'City Car', 'year' => '2023-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Honda']],
            ['series_number' => 'HND-003', 'name' => 'Honda Jazz', 'price' => 350000, 'type' => 'Hatchback', 'year' => '2020-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Honda']],
            ['series_number' => 'SUZ-001', 'name' => 'Suzuki Ertiga', 'price' => 330000, 'type' => 'MPV', 'year' => '2019-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Suzuki']],
            ['series_number' => 'SUZ-002', 'name' => 'Suzuki XL7', 'price' => 420000, 'type' => 'SUV', 'year' => '2023-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Suzuki']],
            ['series_number' => 'SUZ-003', 'name' => 'Suzuki Baleno', 'price' => 300000, 'type' => 'Hatchback', 'year' => '2022-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Suzuki']],
            ['series_number' => 'SUZ-004', 'name' => 'Suzuki Ignis', 'price' => 280000, 'type' => 'City Car', 'year' => '2023-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Suzuki']],
            ['series_number' => 'SUZ-005', 'name' => 'Suzuki Swift', 'price' => 290000, 'type' => 'Hatchback', 'year' => '2020-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Suzuki']],
            ['series_number' => 'SUZ-006', 'name' => 'Suzuki Carry', 'price' => 260000, 'type' => 'Pickup', 'year' => '2021-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Suzuki']],
            ['series_number' => 'SUZ-007', 'name' => 'Suzuki Jimny', 'price' => 650000, 'type' => 'SUV', 'year' => '2021-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Suzuki']],
            ['series_number' => 'MIT-001', 'name' => 'Mitsubishi Xpander', 'price' => 430000, 'type' => 'MPV', 'year' => '2022-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Mitsubishi']],
            ['series_number' => 'MIT-002', 'name' => 'Mitsubishi Pajero Sport', 'price' => 900000, 'type' => 'SUV', 'year' => '2022-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Mitsubishi']],
            ['series_number' => 'MIT-003', 'name' => 'Mitsubishi Xforce', 'price' => 600000, 'type' => 'SUV', 'year' => '2024-01-01', 'status' => 'Available', 'is_electric' => false, 'brand_id' => $brands['Mitsubishi']],
            ['series_number' => 'TSL-001', 'name' => 'Tesla Model 3', 'price' => 1500000, 'type' => 'Electric', 'year' => '2024-01-01', 'status' => 'Available', 'is_electric' => true, 'brand_id' => $brands['Tesla']],
        ];

        foreach ($cars as $car) {
            DB::table('car')->updateOrInsert(['series_number' => $car['series_number']], $car);
        }
    }
}
