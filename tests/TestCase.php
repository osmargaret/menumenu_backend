<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\State;

abstract class TestCase extends BaseTestCase
{
    protected static $seeded = false;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed the database only once for the entire test suite
        if (!self::$seeded) {
            // Ensure that the state with id=1 exists for the foreign key constraint in users table
            if (!State::find(1)) {
                State::create([
                    'id' => 1,
                    'name' => 'Default State',
                    'slug' => Str::slug('Default State'),
                ]);
            }

            // Seed the states and cities if we only have the default state (to avoid seeding on every test)
            if (State::count() === 1) {
                Artisan::call('db:seed', [
                    '--class' => 'NigeriaStatesCitiesSeeder',
                ]);
            }

            self::$seeded = true;
        }
    }
}
