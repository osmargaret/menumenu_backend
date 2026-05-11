<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\IpLocationService;
use App\Models\State;

class DetectStateByIp
{
    public function handle($request, Closure $next)
    {
        if (session()->has('state_id')) {
            return $next($request);
        }

        $ip = $request->ip();
        $service = app(IpLocationService::class);
        $loc = $service->lookup($ip);
        if ($loc && ($loc['countryCode'] ?? null) === 'NG' && ! empty($loc['regionName'])) {
            $state = State::whereRaw('LOWER(name) = ?', [strtolower($loc['regionName'])])->first();
            if (! $state) {
                $state = State::where('slug', \Illuminate\Support\Str::slug($loc['regionName']))->first();
            }

            if ($state) {
                session(['state_id' => $state->id]);
            }
        }

        return $next($request);
    }
}
