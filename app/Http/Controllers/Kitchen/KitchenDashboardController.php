<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Meal;
use App\Models\Kitchen;
use Illuminate\Http\Request;

class KitchenDashboardController extends Controller
{
    /**
     * Get the kitchen dashboard stats.
     * GET /kitchen/dashboard
     */
    public function stats(Request $request)
    {
        $kitchen = $request->user();

        if (!$kitchen instanceof \App\Models\Kitchen) {
            return response()->json(['message' => 'Unauthorized: kitchen only'], 403);
        }

        $orders = Order::where('kitchen_id', $kitchen->id);

        $stats = [
            'total_orders'    => (clone $orders)->count(),
            'pending_orders'  => (clone $orders)->where('status', 'pending')->count(),
            'active_orders'   => (clone $orders)->whereIn('status', ['confirmed', 'preparing', 'ready'])->count(),
            'completed_orders'=> (clone $orders)->where('status', 'delivered')->count(),
            'total_revenue'   => (clone $orders)->where('status', 'delivered')->sum('total'),
            'total_meals'     => Meal::where('kitchen_id', $kitchen->id)->count(),
            'available_meals' => Meal::where('kitchen_id', $kitchen->id)->where('available', true)->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get orders for the authenticated kitchen.
     * GET /kitchen/orders
     */
    public function orders(Request $request)
    {
        $kitchen = $request->user();

        if (!$kitchen instanceof \App\Models\Kitchen) {
            return response()->json(['message' => 'Unauthorized: kitchen only'], 403);
        }

        $query = Order::where('kitchen_id', $kitchen->id)
            ->with('user:id,name,email', 'items.meal')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->paginate(20);
    }

    /**
     * Get meals for the authenticated kitchen.
     * GET /kitchen/meals
     */
    public function meals(Request $request)
    {
        $kitchen = $request->user();

        if (!$kitchen instanceof \App\Models\Kitchen) {
            return response()->json(['message' => 'Unauthorized: kitchen only'], 403);
        }

        return Meal::where('kitchen_id', $kitchen->id)
            ->latest()
            ->paginate(20);
    }
}
