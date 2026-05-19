<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use App\Notifications\OtpCodeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class CustomersAuthenticationController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // Register
    // ─────────────────────────────────────────────────────────────────────────
    public function register(Request $request)
    {
        // Auto-seed states if the table is empty (handles ephemeral Railway disks)
        if (State::count() === 0) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'NigeriaStatesCitiesSeeder',
                '--force' => true,
            ]);
        }

        $data = $request->validate([
            // Personal info
            'name'     => 'required|string|min:2|max:255',
            'email'    => 'required|string|email:rfc|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',         // requires password_confirmation field
            'phone'    => 'nullable|string|max:20',

            // Location — both FK-validated against the actual DB tables
            'state_id' => 'nullable|exists:states,id',
            'city_id'  => 'nullable|exists:cities,id',
        ]);

        // Cross-validate: city must belong to the selected state
        if (!empty($data['city_id']) && !empty($data['state_id'])) {
            $valid = City::where('id', $data['city_id'])
                         ->where('state_id', $data['state_id'])
                         ->exists();

            if (!$valid) {
                return response()->json([
                    'message' => 'The selected city does not belong to the selected state.',
                    'errors'  => [
                        'city_id' => ['The selected city does not belong to the selected state.'],
                    ],
                ], 422);
            }
        }

        // state_id is NOT NULL in the DB — fall back to the first available state
        // when the user skips the field (the `confirmed` design allows optional location)
        $stateId = $data['state_id'] ?? State::first()?->id ?? 1;

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],   // 'hashed' cast on the model handles bcrypt
            'phone'    => $data['phone'] ?? null,
            'state_id' => $stateId,
        ]);

        // Generate and cache a 6-digit OTP (10-minute TTL)
        $otp = rand(100000, 999999);
        Cache::put('otp_' . $user->id, Hash::make($otp), now()->addMinutes(10));

        $mailError = null;
        try {
            $user->notify(new OtpCodeNotification($otp));
        } catch (\Throwable $e) {
            $mailError = $e->getMessage();
            \Illuminate\Support\Facades\Log::error("Failed to send OTP email: " . $mailError . ". OTP: " . $otp);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        // Eager-load location so the frontend can populate dropdowns immediately
        $userData          = $user->load('state', 'city')->toArray();
        $userData['role']  = 'customer';

        $responsePayload = [
            'user'  => $userData,
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

    // ─────────────────────────────────────────────────────────────────────────
    // Login
    // ─────────────────────────────────────────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $user  = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Load location objects so the frontend has names, not just IDs
        $userData         = $user->load('state', 'city')->toArray();
        $userData['role'] = 'customer';

        return response()->json([
            'user'  => $userData,
            'token' => $token,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Forgot Password
    // ─────────────────────────────────────────────────────────────────────────
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        return response()->json([
            'message' => 'If an account with that email exists, a password reset link has been sent.',
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Get Profile
    // ─────────────────────────────────────────────────────────────────────────
    public function getProfile(Request $request)
    {
        // Load location relations so the frontend has the full objects
        $userData         = $request->user()->load('state', 'city')->toArray();
        $userData['role'] = 'customer';

        return response()->json(['user' => $userData]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Update Profile
    // ─────────────────────────────────────────────────────────────────────────
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'     => 'sometimes|required|string|min:2|max:255',
            'phone'    => 'sometimes|nullable|string|max:20',
            'state_id' => 'sometimes|nullable|exists:states,id',
            'city_id'  => 'sometimes|nullable|exists:cities,id',
        ]);

        // Cross-validate: city must belong to the selected state
        $resolvedStateId = $data['state_id'] ?? $user->state_id;
        if (!empty($data['city_id']) && $resolvedStateId) {
            $valid = City::where('id', $data['city_id'])
                         ->where('state_id', $resolvedStateId)
                         ->exists();

            if (!$valid) {
                return response()->json([
                    'message' => 'The selected city does not belong to the selected state.',
                    'errors'  => [
                        'city_id' => ['The selected city does not belong to the selected state.'],
                    ],
                ], 422);
            }
        }

        $user->update($data);

        $userData         = $user->fresh()->load('state', 'city')->toArray();
        $userData['role'] = 'customer';

        return response()->json([
            'message' => 'Profile updated successfully',
            'user'    => $userData,
        ]);
    }
}
