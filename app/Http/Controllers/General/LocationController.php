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
        $states = State::all();
        return response()->json($states,200);
    }

    /*
    |--------------------------------------------------------------------------
    | GET /api/states/{state}/cities
    | Returns all cities that belong to the given state.
    | Used to populate the city dropdown after the user picks a state.
    |--------------------------------------------------------------------------
    */
    public function cities()
    {
        if(request()->has('state_id')){
            $cities = City::where('state_id', request()->state_id)->get();
        } else {
            $cities = City::all();
        }
        return response()->json($cities);
    }
}
