<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KitchenVerification;
use Illuminate\Http\Request;

class KitchenVerificationController extends Controller
{
    public function index(Request $request)
    {
        return KitchenVerification::with(['kitchen','reviewer'])->latest()->paginate(20);
    }

    public function show(KitchenVerification $kitchenVerification)
    {
        return $kitchenVerification->load(['kitchen','reviewer']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kitchen_id' => 'required|exists:kitchens,id',
            'status' => 'in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $verification = KitchenVerification::create($data);

        return response()->json($verification, 201);
    }

    public function update(Request $request, KitchenVerification $kitchenVerification)
    {
        $data = $request->validate([
            'status' => 'in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $kitchenVerification->update(array_merge($data, ['reviewed_by' => $request->user()?->id, 'reviewed_at' => now()]));

        return $kitchenVerification->fresh();
    }

    public function destroy(KitchenVerification $kitchenVerification)
    {
        $kitchenVerification->delete();
        return response()->noContent();
    }
}
