<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Notifications\OtpCodeNotification;
use App\Models\Kitchen;

class KitchenAuthenticationController extends Controller
{
    public function register(Request $request)
    {
        // Auto-run migrations if states table doesn't exist yet
        if (!\Illuminate\Support\Facades\Schema::hasTable('states')) {
            try {
                \Illuminate\Support\Facades\Artisan::call('migrate', [
                    '--force' => true,
                ]);
            } catch (\Throwable $e) {}
        }

        // Auto-seed states if the table is empty (handles ephemeral Railway disks)
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('states') && \App\Models\State::count() === 0) {
                \Illuminate\Support\Facades\Artisan::call('db:seed', [
                    '--class' => 'NigeriaStatesCitiesSeeder',
                    '--force' => true,
                ]);
            }
        } catch (\Throwable $e) {}

        $data = $request->validate([
            'business_name'     => 'required|string|min:2|max:255|unique:kitchens,name',
            'owner_name'     => 'required|string|min:2|max:255',
            'email'    => 'required|string|email:rfc|max:255|unique:kitchens,email',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'state_id' => 'nullable|exists:states,id',
            'city_id'  => 'nullable|exists:cities,id',
        ]);

        $stateId = $data['state_id'] ?? \App\Models\State::first()?->id ?? 1;

        $kitchen = \App\Models\Kitchen::create([
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
        Cache::put('otp_'.$kitchen->id, $hashedOtp, now()->addMinutes(10));

        $mailError = null;
        try {
            $kitchen->notify(new OtpCodeNotification($otp));
        } catch (\Throwable $e) {
            $mailError = $e->getMessage();
            \Illuminate\Support\Facades\Log::error("Failed to send OTP email to kitchen: " . $mailError . ". OTP: " . $otp);
        }

        $token = $kitchen->createToken('kitchen_token')->plainTextToken;

        $kitchenData = $kitchen->load('state', 'city')->toArray();
        $kitchenData['role'] = 'kitchen';

        $responsePayload = [
            'user'  => $kitchenData,
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

        $kitchen = \App\Models\Kitchen::where('email', $request->email)->first();

        if (!$kitchen || !\Illuminate\Support\Facades\Hash::check($request->password, $kitchen->password)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $token = $kitchen->createToken('kitchen_token')->plainTextToken;

        $kitchenData = $kitchen->load('state', 'city')->toArray();
        $kitchenData['role'] = 'kitchen';

        return response()->json([
            'user'  => $kitchenData,
            'token' => $token,
        ]);
    }

    public function profile(Request $request)
    {
        $kitchen = $request->user();

        // Additional sanity check just in case this route gets hit by another user type
        if (!$kitchen instanceof \App\Models\Kitchen) {
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

        $kitchen->update($data);

        $kitchenData = $kitchen->fresh()->load('state', 'city')->toArray();
        $kitchenData['role'] = 'kitchen';

        return response()->json([
            'message' => 'Profile updated successfully',
            'user'    => $kitchenData,
        ]);
    }
}
