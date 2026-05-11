<?php

namespace Database\Factories;

use App\Models\VendorArea;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorAreaFactory extends Factory
{
    protected $model = VendorArea::class;

    public function definition()
    {
        return [
            'vendor_id' => null,
            'name' => $this->faker->city(),
            'fee' => $this->faker->numberBetween(300, 1200),
            'min_delivery_time' => $this->faker->numberBetween(15, 60),
        ];
    }
}
