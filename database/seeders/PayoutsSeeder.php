<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payout;
use App\Models\Vendor;

class PayoutsSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::limit(5)->get();

        foreach ($vendors as $vendor) {
            Payout::create([
                'vendor_id' => $vendor->id,
                'amount' => 10000,
                'fee' => 500,
                'status' => 'paid',
                'method' => 'bank_transfer',
                'meta' => ['tx' => 'seed-payout-'.$vendor->id],
                'paid_at' => now(),
            ]);
        }
    }
}
