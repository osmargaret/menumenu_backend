<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with('user','items.meal')->latest()->paginate(20);
    }

    public function show(Order $order)
    {
        return $order->load('user','items.meal');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'vendor_id' => 'required|exists:vendors,id',
            'total' => 'required|integer|min:0',
            'items' => 'required|array|min:1',
            'items.*.meal_id' => 'required|exists:meals,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|integer|min:0',
        ]);

        $order = null;

        DB::transaction(function () use ($data, &$order) {
            $order = Order::create([
                'user_id' => $data['user_id'],
                'vendor_id' => $data['vendor_id'],
                'total' => $data['total'],
                'status' => 'pending',
            ]);

            foreach ($data['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'meal_id' => $item['meal_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        });

        return response()->json($order->load('items.meal'), 201);
    }

    public function update(\App\Http\Requests\UpdateOrderStatusRequest $request, Order $order)
    {
        $this->authorize('update', $order);

        $data = $request->validated();
        $order->update($data);
        return $order->fresh()->load('items.meal');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->noContent();
    }
}
