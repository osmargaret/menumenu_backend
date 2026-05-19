<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Notifications\OtpCodeNotification;
use App\Models\Vendor;

class VendorAuthenticationController extends Controller
{
    public function register(Request $request)
    {
        // Auto-seed if the table is empty (handles ephemeral Railway disks)
        if (\App\Models\State::count() === 0) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'NigeriaStatesCitiesSeeder',
                '--force' => true
            ]);
        }

        $data = $request->validate([
            'name'     => 'required|string|min:2|max:255|unique:vendors,name',
            'email'    => 'required|string|email:rfc|max:255|unique:vendors,email',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'state_id' => 'nullable|exists:states,id',
            'city_id'  => 'nullable|exists:cities,id',
        ]);

        $stateId = $data['state_id'] ?? \App\Models\State::first()?->id ?? 1;

        $vendor = \App\Models\Vendor::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
            'slug'     => \Illuminate\Support\Str::slug($data['name']) . '-' . uniqid(),
            'phone'    => $data['phone'] ?? null,
            'state_id' => $stateId,
            'city_id'  => $data['city_id'] ?? null,
        ]);

        // Generate and send OTP
        $otp = rand(100000, 999999);
        $hashedOtp = Hash::make($otp);
        Cache::put('otp_'.$vendor->id, $hashedOtp, now()->addMinutes(10));

        $mailError = null;
        try {
            $vendor->notify(new OtpCodeNotification($otp));
        } catch (\Throwable $e) {
            $mailError = $e->getMessage();
            \Illuminate\Support\Facades\Log::error("Failed to send OTP email to vendor: " . $mailError . ". OTP: " . $otp);
        }

        $token = $vendor->createToken('vendor_token')->plainTextToken;

        $vendorData = $vendor->load('state', 'city')->toArray();
        $vendorData['role'] = 'vendor';

        $responsePayload = [
            'user'  => $vendorData,
            'token' => $token,
        ];

        // Return dev_otp if debug mode is active or mail delivery failed
        if (config('app.debug') || $mailError) {
            $responsePayload['_dev_otp'] = $otp;
            if ($mailError) {
                $responsePayload['_mail_error'] = "Mail delivery failed, using dev OTP fallback: " . $mailError;
            }
        }

        return response()->json($responsePayload, 201);
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

        $vendorData = $vendor->load('state', 'city')->toArray();
        $vendorData['role'] = 'vendor';

        return response()->json([
            'user'  => $vendorData,
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

        $vendorData = $vendor->fresh()->load('state', 'city')->toArray();
        $vendorData['role'] = 'vendor';

        return response()->json([
            'message' => 'Profile updated successfully',
            'user'    => $vendorData,
        ]);
    }
}
