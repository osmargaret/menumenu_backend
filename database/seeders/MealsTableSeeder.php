<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure meals are attached to vendors created in VendorsTableSeeder
        $vendors = \App\Models\Vendor::all();

        if ($vendors->isEmpty()) {
            // fallback: create some vendors first
            $vendor = \App\Models\Vendor::factory()->create();
            Meal::factory()->count(10)->create(['vendor_id' => $vendor->id]);
            return;
        }

        foreach ($vendors as $vendor) {
            if ($vendor->meals()->exists()) {
                continue;
            }
            Meal::factory()->count(6)->create(['vendor_id' => $vendor->id]);
        }
    }
}
