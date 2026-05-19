<?php

namespace Database\Factories;

use App\Models\Meal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MealFactory extends Factory
{
    protected $model = Meal::class;

    public function definition()
    {
        $name = $this->faker->words(3, true);
        return [
            'kitchen_id' => null,
            'name' => ucfirst($name),
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(500, 6000),
            'currency' => 'NGN',
            'available' => $this->faker->boolean(90),
            'prep_time' => $this->faker->numberBetween(10, 60),
            'category' => $this->faker->randomElement(['Main', 'Sides', 'Dessert', 'Drinks', 'Breakfast']),
        ];
    }
}
