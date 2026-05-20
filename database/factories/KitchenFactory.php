<?php

namespace Database\Factories;

use App\Models\Kitchen;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KitchenFactory extends Factory
{
    protected $model = Kitchen::class;

    public function definition()
    {
        $name = $this->faker->company();
        return [
            'user_id' => null,
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 9999),
            'email' => $this->faker->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'tagline' => $this->faker->catchPhrase(),
            'description' => $this->faker->paragraph(),
            'address' => $this->faker->address(),
            'is_open' => $this->faker->boolean(70),
            'open_time' => $this->faker->time(),
            'close_time' => $this->faker->time(),
            'delivery_available' => true,
            'pickup_available' => true,
            'commission_percent' => 10,
            'state_id' => \App\Models\State::first()?->id ?? 1,
            'city_id' => \App\Models\City::first()?->id ?? 1,
        ];
    }
}
