<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'order_number' => strtoupper(Str::random(10)),
            'user_id' => null,
            'vendor_id' => null,
            'subtotal' => 0,
            'delivery_fee' => 0,
            'discount' => 0,
            'total' => 0,
            'status' => 'pending',
            'payment_method' => 'card',
            'address' => [
                'name' => $this->faker->name(),
                'phone' => $this->faker->phoneNumber(),
                'street' => $this->faker->streetAddress(),
                'city' => $this->faker->city(),
            ],
        ];
    }
}
