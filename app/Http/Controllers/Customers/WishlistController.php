<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Get the authenticated user's wishlist.
     */
    public function index()
    {
        $items = Wishlist::where('user_id', auth()->id())
            ->with('meal.kitchen')
            ->latest()
            ->get();

        return response()->json($items);
    }

    /**
     * Add a meal to the wishlist.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'meal_id' => 'required|exists:meals,id',
        ]);

        $item = Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'meal_id' => $data['meal_id'],
        ]);

        return response()->json($item->load('meal.kitchen'), 201);
    }

    /**
     * Remove a meal from the wishlist.
     */
    public function destroy(Request $request, $mealId)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('meal_id', $mealId)
            ->delete();

        return response()->noContent();
    }
}
