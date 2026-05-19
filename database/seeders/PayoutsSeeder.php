<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payout;
use App\Models\Kitchen;

class PayoutsSeeder extends Seeder
{
    public function run(): void
    {
        $kitchens = Kitchen::limit(5)->get();

        foreach ($kitchens as $kitchen) {
            Payout::create([
                'kitchen_id' => $kitchen->id,
                'amount' => 10000,
                'fee' => 500,
                'status' => 'paid',
                'method' => 'bank_transfer',
                'meta' => ['tx' => 'seed-payout-'.$kitchen->id],
                'paid_at' => now(),
            ]);
        }
    }
}
