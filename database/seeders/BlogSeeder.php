<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Kitchen;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $kitchens = Kitchen::all();

        foreach ($kitchens as $kitchen) {
            if ($kitchen->blogPosts()->exists()) {
                continue;
            }
            BlogPost::factory()->count(2)->create(['kitchen_id' => $kitchen->id]);
        }
    }
}
