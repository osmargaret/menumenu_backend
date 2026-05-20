<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\State;
use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $lagosState = State::where('slug', 'lagos')->first() ?? State::first();
        $lagosStateId = $lagosState?->id ?? 1;
        
        $ikejaCity = City::where('slug', 'lagos-ikeja')->first() ?? City::where('state_id', $lagosStateId)->first();
        $ikejaCityId = $ikejaCity?->id;

        $password = Hash::make('password');

        // 2. Seed Test User
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'phone' => '+2348023456789',
                'password' => $password,
                'state_id' => $lagosStateId,
                'city_id' => $ikejaCityId,
                'email_verified_at' => now(),
            ]
        );

        // 3. Seed Clem User (the user of the system)
        User::updateOrCreate(
            ['email' => 'clem@menumenu.com'],
            [
                'name' => 'Clement Alao',
                'phone' => '+2348099887766',
                'password' => $password,
                'state_id' => $lagosStateId,
                'city_id' => $ikejaCityId,
                'email_verified_at' => now(),
            ]
        );

        // 4. Seed Kitchen Owners (12 of them to match the 12 mock kitchen brands)
        $owners = [
            ['email' => 'mama.t@menumenu.com', 'name' => 'Theresa Balogun', 'phone' => '+2348033112233'],
            ['email' => 'oven.fresh@menumenu.com', 'name' => 'Kunle Bakare', 'phone' => '+2348033223344'],
            ['email' => 'spice.palace@menumenu.com', 'name' => 'Amadi Okoye', 'phone' => '+2348033334455'],
            ['email' => 'suya.republic@menumenu.com', 'name' => 'Musa YarAdua', 'phone' => '+2348033445566'],
            ['email' => 'morning.glory@menumenu.com', 'name' => 'Aisha Bello', 'phone' => '+2348033556677'],
            ['email' => 'ocean.catch@menumenu.com', 'name' => 'Tariq Johnson', 'phone' => '+2348033667788'],
            ['email' => 'naija.swallow@menumenu.com', 'name' => 'Chioma Nze', 'phone' => '+2348033778899'],
            ['email' => 'sweet.tooth@menumenu.com', 'name' => 'Yinka Falobi', 'phone' => '+2348033889900'],
            ['email' => 'grill.house@menumenu.com', 'name' => 'Damilola Adebayo', 'phone' => '+2348033990011'],
            ['email' => 'jollof.junction@menumenu.com', 'name' => 'Bolanle Shonibare', 'phone' => '+2348034112233'],
            ['email' => 'bites.bakes@menumenu.com', 'name' => 'Emeka Nwachukwu', 'phone' => '+2348034223344'],
            ['email' => 'village.pot@menumenu.com', 'name' => 'Fatima Yusuf', 'phone' => '+2348034334455'],
        ];

        foreach ($owners as $owner) {
            User::updateOrCreate(
                ['email' => $owner['email']],
                [
                    'name' => $owner['name'],
                    'phone' => $owner['phone'],
                    'password' => $password,
                    'state_id' => $lagosStateId,
                    'city_id' => $ikejaCityId,
                    'email_verified_at' => now(),
                ]
            );
        }

        // 5. Seed Premium Nigerian Customers
        $customers = [
            ['email' => 'tunde@menumenu.com', 'name' => 'Tunde Folawiyo', 'phone' => '+2348055551111'],
            ['email' => 'funmi@menumenu.com', 'name' => 'Funmi Iyanda', 'phone' => '+2348055552222'],
            ['email' => 'chinedu@menumenu.com', 'name' => 'Chinedu Echeruo', 'phone' => '+2348055553333'],
            ['email' => 'halima@menumenu.com', 'name' => 'Halima Dangote', 'phone' => '+2348055554444'],
            ['email' => 'yemi@menumenu.com', 'name' => 'Yemi Alade', 'phone' => '+2348055555555'],
        ];

        foreach ($customers as $cust) {
            User::updateOrCreate(
                ['email' => $cust['email']],
                [
                    'name' => $cust['name'],
                    'phone' => $cust['phone'],
                    'password' => $password,
                    'state_id' => $lagosStateId,
                    'city_id' => $ikejaCityId,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
