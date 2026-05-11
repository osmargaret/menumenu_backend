<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::all();

        foreach ($vendors as $vendor) {
            if ($vendor->blogPosts()->exists()) {
                continue;
            }
            BlogPost::factory()->count(2)->create(['vendor_id' => $vendor->id]);
        }
    }
}
