<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition()
    {
        $title = $this->faker->sentence(6);
        return [
            'kitchen_id' => null,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'excerpt' => $this->faker->sentence(),
            'body' => $this->faker->paragraphs(3, true),
            'views' => $this->faker->numberBetween(0, 5000),
            'is_published' => true,
            'published_at' => now(),
        ];
    }
}
