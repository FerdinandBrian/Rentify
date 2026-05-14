<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenaltySeeder extends Seeder
{
    public function run(): void
    {
        $penalties = [
            [
                'type' => 'Late Return',
                'total_penalty' => 100000.00,
            ],
            [
                'type' => 'Smoking in Car',
                'total_penalty' => 500000.00,
            ],
            [
                'type' => 'Dirty Interior',
                'total_penalty' => 200000.00,
            ],
        ];

        foreach ($penalties as $penalty) {
            DB::table('penalty')->updateOrInsert(
                ['type' => $penalty['type']],
                $penalty
            );
        }
    }
}
