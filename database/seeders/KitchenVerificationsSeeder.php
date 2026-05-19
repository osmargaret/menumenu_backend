<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KitchenVerification;
use App\Models\Kitchen;
use App\Models\User;

class KitchenVerificationsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $kitchens = Kitchen::limit(5)->get();

        foreach ($kitchens as $kitchen) {
            KitchenVerification::create([
                'kitchen_id' => $kitchen->id,
                'status' => 'approved',
                'reviewed_by' => $admin?->id,
                'notes' => 'Auto-approved during seeding',
                'reviewed_at' => now(),
            ]);
        }
    }
}
