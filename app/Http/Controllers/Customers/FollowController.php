<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Vendor;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * List vendors that the authenticated user follows.
     */
    public function index()
    {
        $follows = Follow::where('user_id', auth()->id())
            ->with('vendor:id,name,slug,avatar_path,tagline,is_open')
            ->latest()
            ->get();

        return response()->json($follows);
    }

    /**
     * Toggle follow/unfollow a vendor.
     * POST /vendors/{vendor}/follow
     */
    public function toggle(Vendor $vendor)
    {
        $userId = auth()->id();

        $existing = Follow::where('user_id', $userId)
            ->where('vendor_id', $vendor->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['following' => false]);
        }

        Follow::create([
            'user_id'   => $userId,
            'vendor_id' => $vendor->id,
        ]);

        return response()->json(['following' => true], 201);
    }
}
