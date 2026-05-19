<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vendor;
use App\Notifications\OtpCodeNotification;

class OtpController extends Controller
{
    /**
     * Resolve the authenticatable model by email.
     * Checks users first, then vendors.
     */
    private function resolveModel(string $email, string $type = 'customer')
    {
        if ($type === 'vendor') {
            return Vendor::where('email', $email)->first();
        }
        return User::where('email', $email)->first();
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string|size:6',
            'type'  => 'nullable|in:customer,vendor',
        ]);

        $type = $request->input('type', 'customer');
        $model = $this->resolveModel($request->email, $type);

        if (!$model) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        $cachedOtp = Cache::get('otp_' . $model->id);

        if (!$cachedOtp || !Hash::check($request->otp, $cachedOtp)) {
            return response()->json(['message' => 'Invalid or expired OTP'], 422);
        }

        // Mark email as verified
        $model->email_verified_at = now();
        $model->save();

        // Clear OTP from cache
        Cache::forget('otp_' . $model->id);

        // Create token
        $tokenName = $type === 'vendor' ? 'vendor_token' : 'auth_token';
        $token = $model->createToken($tokenName)->plainTextToken;

        $modelData = $model->toArray();
        $modelData['role'] = $type === 'vendor' ? 'vendor' : 'customer';

        return response()->json([
            'user'  => $modelData,
            'token' => $token,
        ]);
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'type'  => 'nullable|in:customer,vendor',
        ]);

        $type = $request->input('type', 'customer');
        $model = $this->resolveModel($request->email, $type);

        if (!$model) {
            return response()->json(['message' => 'If the account exists, an OTP has been sent.'], 200);
        }

        $otp = rand(100000, 999999);
        $hashedOtp = Hash::make($otp);
        Cache::put('otp_' . $model->id, $hashedOtp, now()->addMinutes(10));
        
        $mailError = null;
        try {
            $model->notify(new OtpCodeNotification($otp));
        } catch (\Throwable $e) {
            $mailError = $e->getMessage();
            \Illuminate\Support\Facades\Log::error("Failed to resend OTP email: " . $mailError . ". OTP: " . $otp);
        }

        $responsePayload = ['message' => 'OTP resent'];
        if (config('app.debug') || $mailError) {
            $responsePayload['_dev_otp'] = $otp;
            if ($mailError) {
                $responsePayload['_mail_error'] = "Mail delivery failed, using dev OTP fallback: " . $mailError;
            }
        }

        return response()->json($responsePayload, 200);
    }
}
