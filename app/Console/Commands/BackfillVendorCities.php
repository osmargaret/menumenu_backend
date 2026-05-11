<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vendor;
use App\Models\City;
use Illuminate\Support\Str;

class BackfillVendorCities extends Command
{
    protected $signature = 'vendor:backfill-cities {--dry-run}';
    protected $description = 'Backfill vendors.city string into cities table and set city_id/state_id';

    public function handle()
    {
        $dry = $this->option('dry-run');
        $vendors = Vendor::whereNotNull('city')->get();
        $this->info("Found {$vendors->count()} vendors with legacy city string");

        foreach ($vendors as $vendor) {
            $cityName = trim($vendor->city);
            if ($cityName === '') {
                continue;
            }

            $city = City::whereRaw('LOWER(name) = ?', [strtolower($cityName)])->first();
            if (! $city) {
                $this->line("Creating city: {$cityName}");
                if (! $dry) {
                    $city = City::create([
                        'state_id' => $vendor->state_id ?? null,
                        'name' => $cityName,
                        'slug' => Str::slug($cityName),
                    ]);
                }
            }

            if ($city) {
                $this->line("Setting vendor {$vendor->id} city_id={$city->id}");
                if (! $dry) {
                    $vendor->city_id = $city->id;
                    if (empty($vendor->state_id) && $city->state_id) {
                        $vendor->state_id = $city->state_id;
                    }
                    $vendor->save();
                }
            }
        }

        $this->info('Backfill complete');
        return 0;
    }
}
