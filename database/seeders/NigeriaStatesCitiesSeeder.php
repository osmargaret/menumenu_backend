<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NigeriaStatesCitiesSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            'Abia' => 'Umuahia',
            'Adamawa' => 'Yola',
            'Akwa Ibom' => 'Uyo',
            'Anambra' => 'Awka',
            'Bauchi' => 'Bauchi',
            'Bayelsa' => 'Yenagoa',
            'Benue' => 'Makurdi',
            'Borno' => 'Maiduguri',
            'Cross River' => 'Calabar',
            'Delta' => 'Asaba',
            'Ebonyi' => 'Abakaliki',
            'Edo' => 'Benin City',
            'Ekiti' => 'Ado-Ekiti',
            'Enugu' => 'Enugu',
            'Gombe' => 'Gombe',
            'Imo' => 'Owerri',
            'Jigawa' => 'Dutse',
            'Kaduna' => 'Kaduna',
            'Kano' => 'Kano',
            'Katsina' => 'Katsina',
            'Kebbi' => 'Birnin Kebbi',
            'Kogi' => 'Lokoja',
            'Kwara' => 'Ilorin',
            'Lagos' => 'Ikeja',
            'Nasarawa' => 'Lafia',
            'Niger' => 'Minna',
            'Ogun' => 'Abeokuta',
            'Ondo' => 'Akure',
            'Osun' => 'Osogbo',
            'Oyo' => 'Ibadan',
            'Plateau' => 'Jos',
            'Rivers' => 'Port Harcourt',
            'Sokoto' => 'Sokoto',
            'Taraba' => 'Jalingo',
            'Yobe' => 'Damaturu',
            'Zamfara' => 'Gusau',
            'Federal Capital Territory' => 'Abuja',
        ];

        foreach ($states as $stateName => $capital) {
            $slug = Str::slug($stateName);
            
            $state = DB::table('states')->where('slug', $slug)->first();
            
            if (!$state) {
                $stateId = DB::table('states')->insertGetId([
                    'name' => $stateName,
                    'slug' => $slug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $stateId = $state->id;
            }

            $citySlug = Str::slug($capital);
            $city = DB::table('cities')->where('slug', $citySlug)->where('state_id', $stateId)->first();
            
            if (!$city) {
                DB::table('cities')->insert([
                    'state_id' => $stateId,
                    'name' => $capital,
                    'slug' => $citySlug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
