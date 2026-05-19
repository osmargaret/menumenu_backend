<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Kitchen;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * List kitchens that the authenticated user follows.
     */
    public function index()
    {
        $follows = Follow::where('user_id', auth()->id())
            ->with('kitchen:id,name,slug,avatar_path,tagline,is_open')
            ->latest()
            ->get();

        return response()->json($follows);
    }

    /**
     * Toggle follow/unfollow a kitchen.
     * POST /kitchens/{kitchen}/follow
     */
    public function toggle(Kitchen $kitchen)
    {
        $userId = auth()->id();

        $existing = Follow::where('user_id', $userId)
            ->where('kitchen_id', $kitchen->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['following' => false]);
        }

        Follow::create([
            'user_id'   => $userId,
            'kitchen_id' => $kitchen->id,
        ]);

        return response()->json(['following' => true], 201);
    }
}
