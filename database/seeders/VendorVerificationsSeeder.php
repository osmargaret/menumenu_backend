<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VendorVerification;
use App\Models\Vendor;
use App\Models\User;

class VendorVerificationsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $vendors = Vendor::limit(5)->get();

        foreach ($vendors as $vendor) {
            VendorVerification::create([
                'vendor_id' => $vendor->id,
                'status' => 'approved',
                'reviewed_by' => $admin?->id,
                'notes' => 'Auto-approved during seeding',
                'reviewed_at' => now(),
            ]);
        }
    }
}
