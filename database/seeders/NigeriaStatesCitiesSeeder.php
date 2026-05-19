<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NigeriaStatesCitiesSeeder extends Seeder
{
    public function run(): void
    {
        $hasCountriesTable = \Illuminate\Support\Facades\Schema::hasTable('countries');
        $hasCountryIdColumn = \Illuminate\Support\Facades\Schema::hasColumn('states', 'country_id');

        $nigeriaId = null;
        if ($hasCountriesTable) {
            // Ensure the countries table has Nigeria; seed it inline if missing
            $nigeria = DB::table('countries')->where('code', 'NG')->first();
            if (!$nigeria) {
                $nigeriaId = DB::table('countries')->insertGetId([
                    'name'       => 'Nigeria',
                    'code'       => 'NG',
                    'phone_code' => '+234',
                    'flag'       => '🇳🇬',
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $nigeriaId = $nigeria->id;
            }
        }

        // state => [array of cities]
        $data = [
            'Abia' => [
                'Umuahia', 'Aba', 'Ohafia', 'Arochukwu', 'Bende',
            ],
            'Adamawa' => [
                'Yola', 'Mubi', 'Numan', 'Jimeta', 'Ganye',
            ],
            'Akwa Ibom' => [
                'Uyo', 'Eket', 'Ikot Ekpene', 'Oron', 'Abak',
            ],
            'Anambra' => [
                'Awka', 'Onitsha', 'Nnewi', 'Ekwulobia', 'Ogidi',
            ],
            'Bauchi' => [
                'Bauchi', 'Azare', 'Misau', 'Katagum', 'Ningi',
            ],
            'Bayelsa' => [
                'Yenagoa', 'Ogbia', 'Sagbama', 'Ekeremor', 'Brass',
            ],
            'Benue' => [
                'Makurdi', 'Gboko', 'Katsina-Ala', 'Otukpo', 'Vandeikya',
            ],
            'Borno' => [
                'Maiduguri', 'Biu', 'Gwoza', 'Monguno', 'Dikwa',
            ],
            'Cross River' => [
                'Calabar', 'Ogoja', 'Ikom', 'Obudu', 'Ugep',
            ],
            'Delta' => [
                'Asaba', 'Warri', 'Sapele', 'Ughelli', 'Agbor',
            ],
            'Ebonyi' => [
                'Abakaliki', 'Afikpo', 'Onueke', 'Ezza', 'Edda',
            ],
            'Edo' => [
                'Benin City', 'Auchi', 'Ekpoma', 'Uromi', 'Igarra',
            ],
            'Ekiti' => [
                'Ado-Ekiti', 'Ikere', 'Oye', 'Ijero', 'Efon-Alaaye',
            ],
            'Enugu' => [
                'Enugu', 'Nsukka', 'Agbani', 'Oji River', 'Udi',
            ],
            'Federal Capital Territory' => [
                'Abuja', 'Gwagwalada', 'Kuje', 'Kubwa', 'Nyanya', 'Gwarinpa', 'Maitama', 'Wuse', 'Asokoro', 'Garki',
            ],
            'Gombe' => [
                'Gombe', 'Kaltungo', 'Billiri', 'Dukku', 'Nafada',
            ],
            'Imo' => [
                'Owerri', 'Orlu', 'Okigwe', 'Oguta', 'Mbaise',
            ],
            'Jigawa' => [
                'Dutse', 'Hadejia', 'Gumel', 'Birnin Kudu', 'Katagum',
            ],
            'Kaduna' => [
                'Kaduna', 'Zaria', 'Kafanchan', 'Saminaka', 'Makarfi',
            ],
            'Kano' => [
                'Kano', 'Bichi', 'Gwarzo', 'Rano', 'Wudil', 'Ungogo',
            ],
            'Katsina' => [
                'Katsina', 'Daura', 'Funtua', 'Malumfashi', 'Mashi',
            ],
            'Kebbi' => [
                'Birnin Kebbi', 'Argungu', 'Zuru', 'Yelwa', 'Jega',
            ],
            'Kogi' => [
                'Lokoja', 'Okene', 'Kabba', 'Ankpa', 'Idah',
            ],
            'Kwara' => [
                'Ilorin', 'Offa', 'Erin-Ile', 'Patigi', 'Lafiagi',
            ],
            'Lagos' => [
                'Ikeja', 'Lagos Island', 'Victoria Island', 'Lekki', 'Surulere',
                'Ikorodu', 'Badagry', 'Epe', 'Agege', 'Mushin', 'Alimosho', 'Yaba',
                'Ajah', 'Isale Eko', 'Ojo', 'Amuwo-Odofin', 'Kosofe', 'Apapa',
            ],
            'Nasarawa' => [
                'Lafia', 'Keffi', 'Akwanga', 'Nasarawa', 'Doma',
            ],
            'Niger' => [
                'Minna', 'Bida', 'Kontagora', 'Suleja', 'Lapai',
            ],
            'Ogun' => [
                'Abeokuta', 'Sagamu', 'Ijebu-Ode', 'Ota', 'Ilaro',
            ],
            'Ondo' => [
                'Akure', 'Ondo', 'Owo', 'Okitipupa', 'Ile-Oluji',
            ],
            'Osun' => [
                'Osogbo', 'Ile-Ife', 'Ilesa', 'Ede', 'Ikirun',
            ],
            'Oyo' => [
                'Ibadan', 'Ogbomosho', 'Oyo', 'Iseyin', 'Saki', 'Igboho',
            ],
            'Plateau' => [
                'Jos', 'Shendam', 'Pankshin', 'Barkin Ladi', 'Langtang',
            ],
            'Rivers' => [
                'Port Harcourt', 'Obio-Akpor', 'Bonny', 'Eleme', 'Ahoada',
                'Degema', 'Omoku', 'Okehi',
            ],
            'Sokoto' => [
                'Sokoto', 'Tambuwal', 'Gwadabawa', 'Isa', 'Wamako',
            ],
            'Taraba' => [
                'Jalingo', 'Wukari', 'Bali', 'Gembu', 'Zing',
            ],
            'Yobe' => [
                'Damaturu', 'Potiskum', 'Gashua', 'Nguru', 'Geidam',
            ],
            'Zamfara' => [
                'Gusau', 'Kaura Namoda', 'Talata-Mafara', 'Anka', 'Zurmi',
            ],
        ];

        foreach ($data as $stateName => $cities) {
            $stateSlug = Str::slug($stateName);

            // Upsert the state with country_id if applicable
            $existing = DB::table('states')->where('slug', $stateSlug)->first();

            if (!$existing) {
                $insertData = [
                    'name'       => $stateName,
                    'slug'       => $stateSlug,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                if ($hasCountryIdColumn && $nigeriaId) {
                    $insertData['country_id'] = $nigeriaId;
                }
                $stateId = DB::table('states')->insertGetId($insertData);
            } else {
                $stateId = $existing->id;
                if ($hasCountryIdColumn && $nigeriaId) {
                    // Update country_id on existing rows that don't have it yet
                    DB::table('states')
                        ->where('id', $stateId)
                        ->whereNull('country_id')
                        ->update(['country_id' => $nigeriaId, 'updated_at' => now()]);
                }
            }

            foreach ($cities as $cityName) {
                // Make city slug unique by prefixing with state slug
                $citySlug = $stateSlug . '-' . Str::slug($cityName);

                DB::table('cities')->updateOrInsert(
                    ['slug' => $citySlug, 'state_id' => $stateId],
                    [
                        'state_id'   => $stateId,
                        'name'       => $cityName,
                        'slug'       => $citySlug,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
