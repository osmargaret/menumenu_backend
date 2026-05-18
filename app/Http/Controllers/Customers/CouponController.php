<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Validate and return coupon details.
     * POST /coupons/validate
     */
    public function validate(Request $request)
    {
        $data = $request->validate([
            'code'      => 'required|string',
            'vendor_id' => 'nullable|exists:vendors,id',
            'subtotal'  => 'nullable|integer|min:0',
        ]);

        $coupon = Coupon::where('code', strtoupper($data['code']))->first();

        if (!$coupon) {
            return response()->json(['message' => 'Invalid coupon code'], 404);
        }

        // Check if coupon is expired
        if ($coupon->expires_at && now()->isAfter($coupon->expires_at)) {
            return response()->json(['message' => 'This coupon has expired'], 422);
        }

        // Check max uses
        if ($coupon->max_uses && $coupon->uses >= $coupon->max_uses) {
            return response()->json(['message' => 'This coupon has reached its usage limit'], 422);
        }

        // Check vendor restriction
        if ($coupon->vendor_id && isset($data['vendor_id']) && $coupon->vendor_id != $data['vendor_id']) {
            return response()->json(['message' => 'This coupon is not valid for this vendor'], 422);
        }

        // Calculate discount amount
        $subtotal = $data['subtotal'] ?? 0;
        $discountAmount = $coupon->type === 'percent'
            ? (int) round($subtotal * $coupon->value / 100)
            : $coupon->value;

        return response()->json([
            'valid'           => true,
            'coupon'          => $coupon,
            'discount_amount' => $discountAmount,
        ]);
    }
}
