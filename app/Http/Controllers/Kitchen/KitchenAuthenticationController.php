<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Notifications\OtpCodeNotification;
use App\Models\Kitchen;
use App\Models\User;
use App\Models\KitchenUser;

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
            'email'    => 'required|string|email:rfc|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'state_id' => 'nullable|exists:states,id',
            'city_id'  => 'nullable|exists:cities,id',
        ]);

        $stateId = $data['state_id'] ?? \App\Models\State::first()?->id ?? 1;

        $user = User::create([
            'name'     => $data['owner_name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'] ?? null,
            'state_id' => $stateId,
            'city_id'  => $data['city_id'] ?? null,
        ]);

        $kitchen = Kitchen::create([
            'user_id'  => $user->id,
            'name'     => $data['business_name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'slug'     => \Illuminate\Support\Str::slug($data['business_name']) . '-' . uniqid(),
            'phone'    => $data['phone'] ?? null,
            'state_id' => $stateId,
            'city_id'  => $data['city_id'] ?? null,
        ]);

        KitchenUser::create([
            'kitchen_id' => $kitchen->id,
            'user_id'    => $user->id,
            'role'       => 'owner',
            'status'     => 'accepted'
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

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $kitchenUser = KitchenUser::where('user_id', $user->id)->first();

        if (!$kitchenUser) {
            return response()->json(['message' => 'You do not belong to any kitchen.'], 403);
        }

        $kitchen = $kitchenUser->kitchen;

        // Generate and cache a 6-digit OTP (10-minute TTL)
        $otp = rand(100000, 999999);
        $hashedOtp = Hash::make($otp);
        Cache::put('otp_' . $kitchen->id, $hashedOtp, now()->addMinutes(10));

        $mailError = null;
        try {
            $user->notify(new \App\Notifications\OtpCodeNotification($otp));
        } catch (\Throwable $e) {
            $mailError = $e->getMessage();
            \Illuminate\Support\Facades\Log::error("Failed to send kitchen login OTP email: " . $mailError . ". OTP: " . $otp);
        }

        $responsePayload = [
            'otp_required' => true,
            'email'        => $user->email,
            'type'         => 'kitchen',
            'message'      => 'A verification code has been sent to your email.',
        ];

        if (config('app.debug') || $mailError) {
            $responsePayload['_dev_otp'] = $otp;
            if ($mailError) {
                $responsePayload['_mail_error'] = "Mail delivery failed, using dev OTP fallback: " . $mailError;
            }
        }

        return response()->json($responsePayload);
    }

    public function profile(Request $request)
    {
        $kitchen = $request->user();

        // Additional sanity check just in case this route gets hit by another user type
        if (!$kitchen instanceof Kitchen) {
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

