<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorVerification;
use Illuminate\Http\Request;

class VendorVerificationController extends Controller
{
    public function index(Request $request)
    {
        return VendorVerification::with(['vendor','reviewer'])->latest()->paginate(20);
    }

    public function show(VendorVerification $vendorVerification)
    {
        return $vendorVerification->load(['vendor','reviewer']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'status' => 'in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $verification = VendorVerification::create($data);

        return response()->json($verification, 201);
    }

    public function update(Request $request, VendorVerification $vendorVerification)
    {
        $data = $request->validate([
            'status' => 'in:pending,approved,rejected',
            'notes' => 'nullable|string',
        ]);

        $vendorVerification->update(array_merge($data, ['reviewed_by' => $request->user()?->id, 'reviewed_at' => now()]));

        return $vendorVerification->fresh();
    }

    public function destroy(VendorVerification $vendorVerification)
    {
        $vendorVerification->delete();
        return response()->noContent();
    }
}
