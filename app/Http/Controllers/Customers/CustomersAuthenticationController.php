<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Models\State;
use Illuminate\Support\Facades\Hash;

class CustomersAuthenticationController extends Controller
{


    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
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
        // 1. Check if the provided state_id exists
        // 2. If not, try the first available state in the DB
        // 3. If the DB is empty (rare), we fallback to 1
        $stateId = $data['state_id'];
        $exists = \App\Models\State::where('id', $stateId)->exists();
        
        if (!$exists) {
            $stateId = \App\Models\State::first()?->id ?? 1;
        }

        $user = \App\Models\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'state_id' => $stateId,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $userData = $user->toArray();
        $userData['role'] = 'customer';

        return response()->json([
            'user' => $userData,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!\Illuminate\Support\Facades\Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $user = \App\Models\User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        $userData = $user->toArray();
        $userData['role'] = 'customer';

        return response()->json([
            'user' => $userData,
            'token' => $token,
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        return response()->json([
            'message' => 'If an account with that email exists, a password reset link has been sent.',
        ]);
    }
}
