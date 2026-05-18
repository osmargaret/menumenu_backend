<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function index()
    {
        return Refund::with(['order','user','vendor'])->latest()->paginate(20);
    }

    public function show(Refund $refund)
    {
        return $refund->load(['order','user','vendor']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'amount' => 'required|integer|min:0',
            'reason' => 'nullable|string',
        ]);

        $refund = Refund::create($data);
        return response()->json($refund, 201);
    }

    public function update(Request $request, Refund $refund)
    {
        $data = $request->validate([
            'status' => 'in:pending,approved,rejected',
        ]);

        $refund->update(array_merge($data, ['processed_by' => $request->user()?->id, 'processed_at' => now()]));

        return $refund->fresh();
    }

    public function destroy(Refund $refund)
    {
        $refund->delete();
        return response()->noContent();
    }
}
