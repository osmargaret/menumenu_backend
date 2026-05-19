<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kitchen;
use App\Models\City;
use Illuminate\Support\Str;

class BackfillKitchenCities extends Command
{
    protected $signature = 'kitchen:backfill-cities {--dry-run}';
    protected $description = 'Backfill kitchens.city string into cities table and set city_id/state_id';

    public function handle()
    {
        $dry = $this->option('dry-run');
        $kitchens = Kitchen::whereNotNull('city')->get();
        $this->info("Found {$kitchens->count()} kitchens with legacy city string");

        foreach ($kitchens as $kitchen) {
            $cityName = trim($kitchen->city);
            if ($cityName === '') {
                continue;
            }

            $city = City::whereRaw('LOWER(name) = ?', [strtolower($cityName)])->first();
            if (! $city) {
                $this->line("Creating city: {$cityName}");
                if (! $dry) {
                    $city = City::create([
                        'state_id' => $kitchen->state_id ?? null,
                        'name' => $cityName,
                        'slug' => Str::slug($cityName),
                    ]);
                }
            }

            if ($city) {
                $this->line("Setting kitchen {$kitchen->id} city_id={$city->id}");
                if (! $dry) {
                    $kitchen->city_id = $city->id;
                    if (empty($kitchen->state_id) && $city->state_id) {
                        $kitchen->state_id = $city->state_id;
                    }
                    $kitchen->save();
                }
            }
        }

        $this->info('Backfill complete');
        return 0;
    }
}
