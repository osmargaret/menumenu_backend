<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET /api/states
    | Returns all Nigerian states ordered alphabetically.
    | Used to populate the state dropdown on register / profile forms.
    |--------------------------------------------------------------------------
    */
    public function states()
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
            if (\Illuminate\Support\Facades\Schema::hasTable('states') && State::count() === 0) {
                \Illuminate\Support\Facades\Artisan::call('db:seed', [
                    '--class' => 'NigeriaStatesCitiesSeeder',
                    '--force' => true,
                ]);
            }
        } catch (\Throwable $e) {}

        $states = \Illuminate\Support\Facades\Schema::hasTable('states') ? State::all() : collect();
        return response()->json($states, 200);
    }

    /*
    |--------------------------------------------------------------------------
    | GET /api/states/{state}/cities
    | Returns all cities that belong to the given state.
    | Used to populate the city dropdown after the user picks a state.
    |--------------------------------------------------------------------------
    */
    public function cities(string $state)
    {
        $cities = City::where('state_id', $state)->get();
        return response()->json($cities);
    }
}
