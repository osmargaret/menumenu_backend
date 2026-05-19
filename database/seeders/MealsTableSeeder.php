<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure meals are attached to kitchens created in KitchensTableSeeder
        $kitchens = \App\Models\Kitchen::all();

        if ($kitchens->isEmpty()) {
            // fallback: create some kitchens first
            $kitchen = \App\Models\Kitchen::factory()->create();
            Meal::factory()->count(10)->create(['kitchen_id' => $kitchen->id]);
            return;
        }

        foreach ($kitchens as $kitchen) {
            if ($kitchen->meals()->exists()) {
                continue;
            }
            Meal::factory()->count(6)->create(['kitchen_id' => $kitchen->id]);
        }
    }
}
