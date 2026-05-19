<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = Order::with('user', 'kitchen', 'items.meal')->latest();

        // If a kitchen is authenticated via kitchen guard, show their orders
        if ($user instanceof \App\Models\Kitchen) {
            $query->where('kitchen_id', $user->id);
        } else {
            // Customer sees only their own orders
            $query->where('user_id', $user->id);
        }

        return $query->paginate(20);
    }

    public function show(Order $order)
    {
        return $order->load('user', 'kitchen', 'items.meal');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kitchen_id'      => 'required|exists:kitchens,id',
            'subtotal'       => 'required|integer|min:0',
            'delivery_fee'   => 'nullable|integer|min:0',
            'discount'       => 'nullable|integer|min:0',
            'total'          => 'required|integer|min:0',
            'payment_method' => 'nullable|string',
            'address'        => 'nullable|array',
            'coupon_code'    => 'nullable|string',
            'items'          => 'required|array|min:1',
            'items.*.meal_id'  => 'required|exists:meals,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price'    => 'required|integer|min:0',
        ]);

        $order = null;

        DB::transaction(function () use ($data, &$order) {
            $order = Order::create([
                'order_number'   => 'FF-' . strtoupper(Str::random(8)),
                'user_id'        => auth()->id(),
                'kitchen_id'      => $data['kitchen_id'],
                'subtotal'       => $data['subtotal'],
                'delivery_fee'   => $data['delivery_fee'] ?? 0,
                'discount'       => $data['discount'] ?? 0,
                'total'          => $data['total'],
                'status'         => 'pending',
                'payment_method' => $data['payment_method'] ?? null,
                'address'        => $data['address'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $meal = Meal::find($item['meal_id']);

                OrderItem::create([
                    'order_id'  => $order->id,
                    'meal_id'   => $item['meal_id'],
                    'kitchen_id' => $data['kitchen_id'],
                    'name'      => $meal ? $meal->name : 'Unknown',
                    'price'     => $item['price'],
                    'quantity'  => $item['quantity'],
                    'subtotal'  => $item['price'] * $item['quantity'],
                ]);
            }
        });

        return response()->json($order->load('kitchen', 'items.meal'), 201);
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
        $this->authorize('delete', $order);
        $order->delete();
        return response()->noContent();
    }
}
