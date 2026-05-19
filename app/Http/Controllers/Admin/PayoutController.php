<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index()
    {
        return Payout::with('kitchen')->latest()->paginate(20);
    }

    public function show(Payout $payout)
    {
        return $payout->load('kitchen');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kitchen_id' => 'required|exists:kitchens,id',
            'amount' => 'required|integer|min:0',
            'fee' => 'nullable|integer|min:0',
            'method' => 'nullable|string',
            'meta' => 'nullable|array',
        ]);

        $payout = Payout::create($data);
        return response()->json($payout, 201);
    }

    public function update(Request $request, Payout $payout)
    {
        $data = $request->validate([
            'status' => 'in:pending,paid,failed',
        ]);

        if (isset($data['status']) && $data['status'] === 'paid') {
            $payout->paid_at = now();
        }

        $payout->update($data);

        return $payout->fresh();
    }

    public function destroy(Payout $payout)
    {
        $payout->delete();
        return response()->noContent();
    }
}
