<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Kitchen;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * List reviews for a kitchen.
     * GET /kitchens/{kitchen}/reviews
     */
    public function index(Kitchen $kitchen)
    {
        $reviews = $kitchen->reviews()
            ->with('user:id,name')
            ->latest()
            ->paginate(15);

        return response()->json($reviews);
    }

    /**
     * Submit a review for a kitchen.
     * POST /kitchens/{kitchen}/reviews
     */
    public function store(Request $request, Kitchen $kitchen)
    {
        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'meal_id' => 'nullable|exists:meals,id',
        ]);

        // Prevent duplicate reviews from the same user for this kitchen
        $existing = Review::where('user_id', auth()->id())
            ->where('kitchen_id', $kitchen->id)
            ->first();

        if ($existing) {
            // Update the existing review instead
            $existing->update($data);
            return response()->json($existing->fresh()->load('user:id,name'));
        }

        $review = Review::create([
            'user_id'   => auth()->id(),
            'kitchen_id' => $kitchen->id,
            'meal_id'   => $data['meal_id'] ?? null,
            'rating'    => $data['rating'],
            'comment'   => $data['comment'] ?? null,
        ]);

        return response()->json($review->load('user:id,name'), 201);
    }

    /**
     * Delete own review.
     * DELETE /reviews/{review}
     */
    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id() && !auth()->user()?->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $review->delete();
        return response()->noContent();
    }
}
