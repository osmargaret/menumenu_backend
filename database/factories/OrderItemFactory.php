<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        return [
            'order_id' => null,
            'meal_id' => null,
            'vendor_id' => null,
            'name' => $this->faker->words(2, true),
            'price' => $this->faker->numberBetween(400, 5000),
            'quantity' => $this->faker->numberBetween(1, 4),
            'subtotal' => 0,
        ];
    }
}
