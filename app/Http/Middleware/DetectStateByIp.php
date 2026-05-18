<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\IpLocationService;
use App\Models\State;
use App\Models\City;
use Illuminate\Support\Str;

class DetectStateByIp
{
    public function handle($request, Closure $next)
    {
        // Only run once per session
        if (session()->has('detected_location')) {
            return $next($request);
        }

        $ip      = $request->ip();
        $service = app(IpLocationService::class);
        $loc     = $service->lookup($ip);

        if (!$loc) {
            return $next($request);
        }

        $regionName = $loc['regionName'] ?? '';
        $cityName   = $loc['city'] ?? '';

        // Match the Nigerian state by name or slug
        $state = null;
        if ($regionName) {
            $state = State::where(function ($q) use ($regionName) {
                $q->whereRaw('LOWER(name) = ?', [strtolower($regionName)])
                  ->orWhere('slug', Str::slug($regionName));
            })->first();
        }

        // Match the city within that state
        $city = null;
        if ($state && $cityName) {
            $city = City::where('state_id', $state->id)
                ->where(function ($q) use ($cityName) {
                    $q->whereRaw('LOWER(name) = ?', [strtolower($cityName)])
                      ->orWhere('slug', Str::slug($cityName));
                })
                ->first();
        }

        session([
            'detected_location' => true,
            'state_id'          => $state?->id,
            'city_id'           => $city?->id,
        ]);

        return $next($request);
    }
}
