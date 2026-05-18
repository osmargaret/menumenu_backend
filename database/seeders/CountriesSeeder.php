<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'Nigeria',             'code' => 'NG', 'phone_code' => '+234', 'flag' => '🇳🇬'],
            ['name' => 'Ghana',               'code' => 'GH', 'phone_code' => '+233', 'flag' => '🇬🇭'],
            ['name' => 'Kenya',               'code' => 'KE', 'phone_code' => '+254', 'flag' => '🇰🇪'],
            ['name' => 'South Africa',        'code' => 'ZA', 'phone_code' => '+27',  'flag' => '🇿🇦'],
            ['name' => 'United Kingdom',      'code' => 'GB', 'phone_code' => '+44',  'flag' => '🇬🇧'],
            ['name' => 'United States',       'code' => 'US', 'phone_code' => '+1',   'flag' => '🇺🇸'],
            ['name' => 'Canada',              'code' => 'CA', 'phone_code' => '+1',   'flag' => '🇨🇦'],
            ['name' => 'Uganda',              'code' => 'UG', 'phone_code' => '+256', 'flag' => '🇺🇬'],
            ['name' => 'Tanzania',            'code' => 'TZ', 'phone_code' => '+255', 'flag' => '🇹🇿'],
            ['name' => 'Cameroon',            'code' => 'CM', 'phone_code' => '+237', 'flag' => '🇨🇲'],
            ['name' => 'Ivory Coast',         'code' => 'CI', 'phone_code' => '+225', 'flag' => '🇨🇮'],
            ['name' => 'Senegal',             'code' => 'SN', 'phone_code' => '+221', 'flag' => '🇸🇳'],
            ['name' => 'Ethiopia',            'code' => 'ET', 'phone_code' => '+251', 'flag' => '🇪🇹'],
            ['name' => 'Egypt',               'code' => 'EG', 'phone_code' => '+20',  'flag' => '🇪🇬'],
            ['name' => 'Rwanda',              'code' => 'RW', 'phone_code' => '+250', 'flag' => '🇷🇼'],
        ];

        foreach ($countries as $country) {
            DB::table('countries')->updateOrInsert(
                ['code' => $country['code']],
                array_merge($country, [
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
