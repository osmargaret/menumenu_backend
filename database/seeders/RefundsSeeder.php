<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Refund;
use App\Models\Order;
use App\Models\User;

class RefundsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $orders = Order::limit(5)->get();

        foreach ($orders as $order) {
            Refund::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'kitchen_id' => $order->kitchen_id,
                'amount' => (int) ($order->total * 0.5),
                'reason' => 'Test refund for seeding',
                'status' => 'approved',
                'processed_by' => $admin?->id,
                'processed_at' => now(),
            ]);
        }
    }
}
