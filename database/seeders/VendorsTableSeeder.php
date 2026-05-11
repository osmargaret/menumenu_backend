<?php

namespace Database\Seeders;

use App\Models\Vendor;
use App\Models\User;
use App\Models\Meal;
use App\Models\VendorArea;
use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    public function run(): void
    {
        // create vendors for some existing users
        $users = User::all();

        foreach ($users->take(8) as $user) {
            if ($user->vendor()->exists()) {
                continue;
            }
            
            $vendor = Vendor::factory()->create(['user_id' => $user->id]);

            // areas
            VendorArea::factory()->count(3)->create(['vendor_id' => $vendor->id]);

            // meals
            Meal::factory()->count(8)->create(['vendor_id' => $vendor->id]);
        }
    }
}
