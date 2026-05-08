<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentidyDemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedBrands();
        $this->seedCars();
        $this->seedOrders();
        $this->seedPayments();
        $this->seedPenalties();
    }

    private function seedBrands(): void
    {
        foreach ([
            ['id' => 1, 'name' => 'Toyota'],
            ['id' => 2, 'name' => 'Honda'],
            ['id' => 3, 'name' => 'Mitsubishi'],
        ] as $brand) {
            DB::table('brand')->updateOrInsert(['id' => $brand['id']], ['name' => $brand['name']]);
        }
    }

    private function seedCars(): void
    {
        $cars = [
            ['series_number' => 'B-1234-RNT', 'name' => 'Toyota Avanza', 'price' => 350000, 'type' => 'MPV', 'year' => '2024-01-01 00:00:00', 'status' => 'tersedia', 'brand_id' => 1],
            ['series_number' => 'B-5678-RNT', 'name' => 'Honda Brio', 'price' => 300000, 'type' => 'City Car', 'year' => '2023-01-01 00:00:00', 'status' => 'disewa', 'brand_id' => 2],
            ['series_number' => 'B-9012-RNT', 'name' => 'Mitsubishi Xpander', 'price' => 450000, 'type' => 'MPV', 'year' => '2025-01-01 00:00:00', 'status' => 'tersedia', 'brand_id' => 3],
        ];

        foreach ($cars as $car) {
            DB::table('car')->updateOrInsert(['series_number' => $car['series_number']], $car);
        }
    }

    private function seedOrders(): void
    {
        $orders = [
            ['id' => 'ORD-1001', 'name' => 'Evelyn Customer', 'call_number' => '081234567892', 'email' => 'customer@example.com', 'status' => 'menunggu', 'start_rent' => now(), 'end_rent' => now()->addDays(2), 'Car_series_number' => 'B-1234-RNT', 'User_id' => 3],
            ['id' => 'ORD-1002', 'name' => 'Raka Pratama', 'call_number' => '082111111111', 'email' => 'raka@example.com', 'status' => 'aktif', 'start_rent' => now()->subDay(), 'end_rent' => now()->addDay(), 'Car_series_number' => 'B-5678-RNT', 'User_id' => 3],
            ['id' => 'ORD-1003', 'name' => 'Sinta Lestari', 'call_number' => '082222222222', 'email' => 'sinta@example.com', 'status' => 'selesai', 'start_rent' => now()->subDays(5), 'end_rent' => now()->subDays(3), 'Car_series_number' => 'B-9012-RNT', 'User_id' => 3],
            ['id' => 'ORD-1004', 'name' => 'Bima Saputra', 'call_number' => '082333333333', 'email' => 'bima@example.com', 'status' => 'dibatalkan', 'start_rent' => now()->subDays(2), 'end_rent' => now()->addDays(1), 'Car_series_number' => 'B-1234-RNT', 'User_id' => 3],
        ];

        foreach ($orders as $order) {
            DB::table('order')->updateOrInsert(['id' => $order['id']], $order);
        }
    }

    private function seedPayments(): void
    {
        $payments = [
            ['id' => 1, 'method' => 'QRIS', 'status' => 'pending', 'total_price' => 700000, 'Order_id' => 'ORD-1001'],
            ['id' => 2, 'method' => 'Virtual Account', 'status' => 'paid', 'total_price' => 600000, 'Order_id' => 'ORD-1002'],
            ['id' => 3, 'method' => 'Cash', 'status' => 'paid', 'total_price' => 900000, 'Order_id' => 'ORD-1003'],
            ['id' => 4, 'method' => 'QRIS', 'status' => 'cancelled', 'total_price' => 0, 'Order_id' => 'ORD-1004'],
        ];

        foreach ($payments as $payment) {
            DB::table('payment')->updateOrInsert(['id' => $payment['id']], $payment);
        }
    }

    private function seedPenalties(): void
    {
        $penalties = [
            ['id' => 1, 'type' => 'Terlambat mengembalikan mobil', 'total_penalty' => 300000],
            ['id' => 2, 'type' => 'Kebersihan mobil kurang baik', 'total_penalty' => 150000],
        ];

        foreach ($penalties as $penalty) {
            DB::table('penalty')->updateOrInsert(['id' => $penalty['id']], $penalty);
        }

        foreach ([
            ['penalty_id' => 1, 'payment_id' => 2],
            ['penalty_id' => 2, 'payment_id' => 3],
        ] as $relation) {
            DB::table('penalty_payment')->updateOrInsert($relation, $relation);
        }
    }
}
