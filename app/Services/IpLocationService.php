<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IpLocationService
{
    /**
     * Lookup IP address location using a simple provider (ip-api.com).
     * Returns array with keys: countryCode, regionName, city or null on failure.
     */
    public function lookup(string $ip): ?array
    {
        try {
            $cacheKey = "ip_location_{$ip}";
            return cache()->remember($cacheKey, 3600, function () use ($ip) {
                $url = "http://ip-api.com/json/".urlencode($ip)."?fields=status,countryCode,regionName,city";
                $res = Http::timeout(3)->get($url);
                if (! $res->ok()) {
                    return null;
                }

                $data = $res->json();
                if (! isset($data['status']) || $data['status'] !== 'success') {
                    return null;
                }
                return [
                    'countryCode' => $data['countryCode'] ?? null,
                    'regionName' => $data['regionName'] ?? null,
                    'city' => $data['city'] ?? null,
                ];
            });
        } catch (\Throwable $e) {
            return null;
        }
    }
}
