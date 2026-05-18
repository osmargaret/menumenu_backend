<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Meal;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorDashboardController extends Controller
{
    /**
     * Get the vendor dashboard stats.
     * GET /vendor/dashboard
     */
    public function stats(Request $request)
    {
        $vendor = $request->user();

        if (!$vendor instanceof \App\Models\Vendor) {
            return response()->json(['message' => 'Unauthorized: vendor only'], 403);
        }

        $orders = Order::where('vendor_id', $vendor->id);

        $stats = [
            'total_orders'    => (clone $orders)->count(),
            'pending_orders'  => (clone $orders)->where('status', 'pending')->count(),
            'active_orders'   => (clone $orders)->whereIn('status', ['confirmed', 'preparing', 'ready'])->count(),
            'completed_orders'=> (clone $orders)->where('status', 'delivered')->count(),
            'total_revenue'   => (clone $orders)->where('status', 'delivered')->sum('total'),
            'total_meals'     => Meal::where('vendor_id', $vendor->id)->count(),
            'available_meals' => Meal::where('vendor_id', $vendor->id)->where('available', true)->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get orders for the authenticated vendor.
     * GET /vendor/orders
     */
    public function orders(Request $request)
    {
        $vendor = $request->user();

        if (!$vendor instanceof \App\Models\Vendor) {
            return response()->json(['message' => 'Unauthorized: vendor only'], 403);
        }

        $query = Order::where('vendor_id', $vendor->id)
            ->with('user:id,name,email', 'items.meal')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return $query->paginate(20);
    }

    /**
     * Get meals for the authenticated vendor.
     * GET /vendor/meals
     */
    public function meals(Request $request)
    {
        $vendor = $request->user();

        if (!$vendor instanceof \App\Models\Vendor) {
            return response()->json(['message' => 'Unauthorized: vendor only'], 403);
        }

        return Meal::where('vendor_id', $vendor->id)
            ->latest()
            ->paginate(20);
    }
}
