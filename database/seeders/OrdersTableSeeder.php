<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Kitchen;
use App\Models\Meal;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $kitchens = Kitchen::all();

        foreach ($users->take(6) as $user) {
            $kitchen = $kitchens->random();
            $order = Order::factory()->create([
                'user_id' => $user->id,
                'kitchen_id' => $kitchen->id,
            ]);

            $meals = Meal::where('kitchen_id', $kitchen->id)->inRandomOrder()->take(3)->get();
            $subtotal = 0;

            foreach ($meals as $meal) {
                $quantity = rand(1,3);
                $price = $meal->price;
                $line = OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'meal_id' => $meal->id,
                    'kitchen_id' => $kitchen->id,
                    'name' => $meal->name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $price * $quantity,
                ]);
                $subtotal += $line->subtotal;
            }

            $order->update([
                'subtotal' => $subtotal,
                'delivery_fee' => 500,
                'discount' => 0,
                'total' => $subtotal + 500,
            ]);
        }
    }
}
