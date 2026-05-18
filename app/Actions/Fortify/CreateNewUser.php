<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Create a newly registered user.
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', PasswordRule::min(8)],
            'state_id' => ['nullable', 'integer', 'exists:states,id'],
        ])->validate();

        // Determine state_id: prefer provided input, then session, then first state fallback
        $stateId = $input['state_id'] ?? session('state_id');

        if (empty($stateId)) {
            if (State::count() === 0) {
                // Create a default state if none exists using query builder to avoid model issues
                $stateId = DB::table('states')->insertGetId([
                    'name' => 'Default State',
                    'slug' => Str::slug('Default State'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $stateId = State::first()?->id ?? 1;
            }
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'state_id' => $stateId,
        ]);
    }
}
