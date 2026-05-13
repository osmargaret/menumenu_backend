<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorAuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:vendors',
            'password' => 'required|string|min:8',
            'state_id' => 'nullable|integer',
        ]);

        // Auto-seed if the table is empty (handles ephemeral Railway disks)
        if (\App\Models\State::count() === 0) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'NigeriaStatesCitiesSeeder',
                '--force' => true
            ]);
        }

        // Resilient state_id selection:
        $stateId = $data['state_id'] ?? 1;
        if (!\App\Models\State::where('id', $stateId)->exists()) {
            $stateId = \App\Models\State::first()?->id ?? 1;
        }

        $vendor = \App\Models\Vendor::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
            'slug' => \Illuminate\Support\Str::slug($data['name']) . '-' . uniqid(),
            'state_id' => $stateId,
        ]);

        $vendor->sendEmailVerificationNotification();

        $token = $vendor->createToken('vendor_token')->plainTextToken;
        
        $vendorData = $vendor->toArray();
        $vendorData['role'] = 'vendor';

        return response()->json([
            'user' => $vendorData,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $vendor = \App\Models\Vendor::where('email', $request->email)->first();

        if (!$vendor || !\Illuminate\Support\Facades\Hash::check($request->password, $vendor->password)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $token = $vendor->createToken('vendor_token')->plainTextToken;
        
        $vendorData = $vendor->toArray();
        $vendorData['role'] = 'vendor';

        return response()->json([
            'user' => $vendorData,
            'token' => $token,
        ]);
    }

    public function profile(Request $request)
    {
        $vendor = $request->user();

        // Additional sanity check just in case this route gets hit by another user type
        if (!$vendor instanceof \App\Models\Vendor) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
            'tagline' => 'sometimes|string',
            'description' => 'sometimes|string',
            'is_open' => 'sometimes|boolean',
            'open_time' => 'sometimes',
            'close_time' => 'sometimes',
        ]);

        $vendor->update($data);

        $vendorData = $vendor->fresh()->toArray();
        $vendorData['role'] = 'vendor';

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $vendorData
        ]);
    }
}
