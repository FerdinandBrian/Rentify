<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RentifyDemoSeeder extends Seeder
{
    public function run(): void
    {
        $customerId = DB::table('users')->where('email', 'customer@example.com')->value('id');
        
        if (!$customerId) {
            $this->command->error("User customer@example.com tidak ditemukan. Harap jalankan UserSeeder terlebih dahulu!");
            return;
        }

        $this->seedDocuments($customerId);

        $this->seedDemoTransactions($customerId);
    }

    private function seedDocuments(int $customerId): void
    {
        $documents = [
            [
                'user_id' => $customerId,
                'document_type' => 'KTP',
                'file_path' => 'assets/documents/ktp_demo.jpg',
                'description' => 'KTP Demo Terverifikasi',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $customerId,
                'document_type' => 'SIM',
                'file_path' => 'assets/documents/sim_demo.jpg',
                'description' => 'SIM A Demo Terverifikasi',
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($documents as $doc) {
            DB::table('documents')->updateOrInsert(
                ['user_id' => $doc['user_id'], 'document_type' => $doc['document_type']],
                $doc
            );
        }
    }

    private function seedDemoTransactions(int $customerId): void
    {
        // Bersihkan data lama agar seeder bersih
        DB::table('penalty_payment')->truncate();
        DB::table('addon_payment')->truncate();
        
        // Nonaktifkan foreign key checks untuk truncate payment dan order
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('payment')->truncate();
        DB::table('order')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil data mobil & addon
        $avanza = 'TYT-001';
        $brio = 'HND-002';
        $xpander = 'MIT-001';
        $tesla = 'TSL-001';

        $addons = DB::table('addon')->pluck('id', 'name');
        
        $order1Id = 'ORD-' . now()->format('ymd') . '-WAIT';
        DB::table('order')->insert([
            'id' => $order1Id,
            'name' => 'Customer Demo',
            'call_number' => '1234567892',
            'email' => 'customer@example.com',
            'status' => 'menunggu',
            'start_rent' => Carbon::now()->addDays(1)->startOfDay(),
            'end_rent' => Carbon::now()->addDays(3)->endOfDay(),
            'Car_series_number' => $avanza,
            'User_id' => $customerId,
        ]);

        $payment1Id = DB::table('payment')->insertGetId([
            'method' => 'QRIS',
            'status' => 'pending',
            'total_price' => 1200000.00, // 3 hari Avanza (350k x 3 = 1.05jt) + GPS (50k) + Insurance (100k)
            'Order_id' => $order1Id,
        ]);

        // Hubungkan Addons ke Payment 1
        if (isset($addons['GPS'])) {
            DB::table('addon_payment')->insert([
                'addon_id' => $addons['GPS'],
                'payment_id' => $payment1Id,
                'total_price' => 50000.00,
            ]);
        }
        if (isset($addons['Insurance'])) {
            DB::table('addon_payment')->insert([
                'addon_id' => $addons['Insurance'],
                'payment_id' => $payment1Id,
                'total_price' => 100000.00,
            ]);
        }

        // ----------------------------------------------------
        // Order 2: Aktif / Sedang Disewa (Honda Brio)
        // ----------------------------------------------------
        $order2Id = 'ORD-' . now()->format('ymd') . '-ACTV';
        DB::table('order')->insert([
            'id' => $order2Id,
            'name' => 'Customer Demo',
            'call_number' => '1234567892',
            'email' => 'customer@example.com',
            'status' => 'aktif',
            'start_rent' => Carbon::now()->subDays(1)->startOfDay(),
            'end_rent' => Carbon::now()->addDays(1)->endOfDay(),
            'Car_series_number' => $brio,
            'User_id' => $customerId,
        ]);

        // Tandai status mobil Brio jadi disewa / rented
        DB::table('car')->where('series_number', $brio)->update(['status' => 'disewa']);

        $payment2Id = DB::table('payment')->insertGetId([
            'method' => 'Virtual Account',
            'status' => 'paid',
            'total_price' => 950000.00, // 3 hari Brio (275k x 3 = 825k) + Driver (150k / hari x 1 = 150k)
            'Order_id' => $order2Id,
        ]);

        if (isset($addons['Driver'])) {
            DB::table('addon_payment')->insert([
                'addon_id' => $addons['Driver'],
                'payment_id' => $payment2Id,
                'total_price' => 150000.00,
            ]);
        }

        // ----------------------------------------------------
        // Order 3: Selesai + Denda Terlambat (Mitsubishi Xpander)
        // ----------------------------------------------------
        $order3Id = 'ORD-' . now()->format('ymd') . '-DONE';
        DB::table('order')->insert([
            'id' => $order3Id,
            'name' => 'Customer Demo',
            'call_number' => '1234567892',
            'email' => 'customer@example.com',
            'status' => 'selesai',
            'start_rent' => Carbon::now()->subDays(5)->startOfDay(),
            'end_rent' => Carbon::now()->subDays(3)->endOfDay(),
            'Car_series_number' => $xpander,
            'User_id' => $customerId,
        ]);

        $payment3Id = DB::table('payment')->insertGetId([
            'method' => 'Cash',
            'status' => 'paid',
            'total_price' => 1290000.00, // 3 hari Xpander (430k x 3)
            'Order_id' => $order3Id,
        ]);

        // Tambah Denda Terlambat ke Selesai
        $penaltyId = DB::table('penalty')->insertGetId([
            'type' => 'Terlambat mengembalikan mobil 1 hari',
            'total_penalty' => 100000.00,
        ]);

        DB::table('penalty_payment')->insert([
            'penalty_id' => $penaltyId,
            'payment_id' => $payment3Id,
        ]);

        // ----------------------------------------------------
        // Order 4: Dibatalkan (Tesla Model 3)
        // ----------------------------------------------------
        $order4Id = 'ORD-' . now()->format('ymd') . '-CNCL';
        DB::table('order')->insert([
            'id' => $order4Id,
            'name' => 'Customer Demo',
            'call_number' => '1234567892',
            'email' => 'customer@example.com',
            'status' => 'dibatalkan',
            'start_rent' => Carbon::now()->subDays(10)->startOfDay(),
            'end_rent' => Carbon::now()->subDays(8)->endOfDay(),
            'Car_series_number' => $tesla,
            'User_id' => $customerId,
        ]);

        DB::table('payment')->insert([
            'method' => 'QRIS',
            'status' => 'cancelled',
            'total_price' => 0.00,
            'Order_id' => $order4Id,
        ]);
    }
}
