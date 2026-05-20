<?php

namespace Database\Factories;

use App\Models\KitchenLogistics;
use Illuminate\Database\Eloquent\Factories\Factory;

class KitchenLogisticsFactory extends Factory
{
    protected $model = KitchenLogistics::class;

    public function definition()
    {
        return [
            'kitchen_id' => null,
            'city_id' => \App\Models\City::first()?->id ?? 1,
            'town' => $this->faker->city(),
            'fee' => $this->faker->numberBetween(300, 1200),
            'min_delivery_time' => $this->faker->numberBetween(15, 60),
        ];
    }
}
