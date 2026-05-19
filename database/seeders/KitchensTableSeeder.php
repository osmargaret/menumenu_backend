<?php

namespace Database\Seeders;

use App\Models\Kitchen;
use App\Models\User;
use App\Models\Meal;
use App\Models\KitchenLogistics;
use Illuminate\Database\Seeder;

class KitchensTableSeeder extends Seeder
{
    public function run(): void
    {
        // create kitchens for some existing users
        $users = User::all();

        foreach ($users->take(8) as $user) {
            if ($user->kitchen()->exists()) {
                continue;
            }
            
            $kitchen = Kitchen::factory()->create(['user_id' => $user->id]);

            // areas
            KitchenLogistics::factory()->count(3)->create(['kitchen_id' => $kitchen->id]);

            // meals
            Meal::factory()->count(8)->create(['kitchen_id' => $kitchen->id]);
        }
    }
}
