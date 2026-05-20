<?php

namespace Database\Seeders;

use App\Models\Kitchen;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use App\Models\KitchenLogistics;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KitchensTableSeeder extends Seeder
{
    public function run(): void
    {
        $lagosState = State::where('slug', 'lagos')->first() ?? State::first();
        $lagosStateId = $lagosState?->id ?? 1;

        $kitchensData = [
            [
                'owner_email' => 'mama.t@menumenu.com',
                'name' => 'Mama T Kitchen',
                'slug' => 'mama-t',
                'tagline' => 'Authentic Swallow & Nigerian Soups',
                'description' => 'Delivering hot, delicious traditional soups and swallows including Pounded Yam, Egusi Soup, Efo Riro, and Okra Soup. Prepared with home-style love.',
                'city_slug' => 'lagos-yaba',
                'address' => '32 Herbert Macaulay Way, Yaba, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c',
                'banner_path' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d',
                'delivery_areas' => [
                    ['town' => 'Yaba', 'fee' => 500],
                    ['town' => 'Surulere', 'fee' => 700],
                    ['town' => 'Ikeja', 'fee' => 1000],
                    ['town' => 'Maryland', 'fee' => 800],
                ]
            ],
            [
                'owner_email' => 'oven.fresh@menumenu.com',
                'name' => 'Oven Fresh Bakery',
                'slug' => 'oven-fresh',
                'tagline' => 'Pastries, Gourmet Cakes & Fresh Bread',
                'description' => 'Your go-to bakery for fresh morning bread, delicious meat pies, donuts, and custom birthday cakes. Baked fresh every morning.',
                'city_slug' => 'lagos-ikeja',
                'address' => '15 Allen Avenue, Ikeja, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90',
                'banner_path' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff',
                'delivery_areas' => [
                    ['town' => 'Ikeja', 'fee' => 400],
                    ['town' => 'Agege', 'fee' => 600],
                    ['town' => 'Maryland', 'fee' => 600],
                    ['town' => 'Yaba', 'fee' => 900],
                ]
            ],
            [
                'owner_email' => 'spice.palace@menumenu.com',
                'name' => 'Spice Palace',
                'slug' => 'spice-palace',
                'tagline' => 'Signature Nigerian Rice Dishes & Grills',
                'description' => 'Famous for our smokey Party Jollof Rice, Fried Rice, Coconut Rice, and grilled chicken or turkey. Quality taste in every pack.',
                'city_slug' => 'lagos-lekki',
                'address' => 'Block 12, Admiralty Way, Lekki Phase 1, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5',
                'banner_path' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092',
                'delivery_areas' => [
                    ['town' => 'Lekki', 'fee' => 600],
                    ['town' => 'Victoria Island', 'fee' => 800],
                    ['town' => 'Ikoyi', 'fee' => 1000],
                    ['town' => 'Ajah', 'fee' => 900],
                ]
            ],
            [
                'owner_email' => 'suya.republic@menumenu.com',
                'name' => 'Suya Republic',
                'slug' => 'suya-republic',
                'tagline' => 'Premium Beef, Chicken & Ram Suya',
                'description' => 'Authentic, spicy, and perfectly grilled northern-style Suya, Tozo, and Kidney. Served with fresh cabbage, onions, and extra yaji spicy seasoning.',
                'city_slug' => 'lagos-surulere',
                'address' => '84 Adeniran Ogunsanya St, Surulere, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1544025162-d76694265947',
                'banner_path' => 'https://images.unsplash.com/photo-1529193591184-b1d58069ecdd',
                'delivery_areas' => [
                    ['town' => 'Surulere', 'fee' => 500],
                    ['town' => 'Mushin', 'fee' => 600],
                    ['town' => 'Yaba', 'fee' => 600],
                    ['town' => 'Oshodi', 'fee' => 800],
                ]
            ],
            [
                'owner_email' => 'morning.glory@menumenu.com',
                'name' => 'Morning Glory',
                'slug' => 'morning-glory',
                'tagline' => 'Premium Breakfast Specials & Cafe Coffee',
                'description' => 'Start your day with fluffy pancakes, scrambled eggs, toasted bread, and sweet plantain sides. Quick breakfast delivery straight to your office.',
                'city_slug' => 'lagos-yaba',
                'address' => '10 Birrel Avenue, Yaba, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085',
                'banner_path' => 'https://images.unsplash.com/photo-1498804103079-a6351b050096',
                'delivery_areas' => [
                    ['town' => 'Yaba', 'fee' => 400],
                    ['town' => 'Surulere', 'fee' => 600],
                    ['town' => 'Maryland', 'fee' => 700],
                ]
            ],
            [
                'owner_email' => 'ocean.catch@menumenu.com',
                'name' => 'Ocean Catch Seafood',
                'slug' => 'ocean-catch',
                'tagline' => 'Fresh Catfish Pepper Soup & Grilled Fish',
                'description' => 'Specializing in premium Point-and-Kill Catfish Pepper Soup, Grilled Croaker Fish, and Seafood Okra. Spicy, fresh, and exceptionally satisfying.',
                'city_slug' => 'lagos-victoria-island',
                'address' => '22 Adeola Odeku St, Victoria Island, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb',
                'banner_path' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2',
                'delivery_areas' => [
                    ['town' => 'Victoria Island', 'fee' => 600],
                    ['town' => 'Lekki', 'fee' => 800],
                    ['town' => 'Ikoyi', 'fee' => 700],
                    ['town' => 'Apapa', 'fee' => 1200],
                ]
            ],
            [
                'owner_email' => 'naija.swallow@menumenu.com',
                'name' => 'Naija Swallow',
                'slug' => 'naija-swallow',
                'tagline' => 'Home of Hand-Pounded Yam & Amala Dudu',
                'description' => 'Hot, fluffy pounded yam and premium Amala dudu served with Gbegiri, Ewedu, and rich local soups. Eat healthy, eat local.',
                'city_slug' => 'lagos-ikeja',
                'address' => '8 Toyin Street, Ikeja, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836',
                'banner_path' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061',
                'delivery_areas' => [
                    ['town' => 'Ikeja', 'fee' => 500],
                    ['town' => 'Maryland', 'fee' => 700],
                    ['town' => 'Ojota', 'fee' => 800],
                    ['town' => 'Yaba', 'fee' => 1000],
                ]
            ],
            [
                'owner_email' => 'sweet.tooth@menumenu.com',
                'name' => 'Sweet Tooth Confectionery',
                'slug' => 'sweet-tooth',
                'tagline' => 'Deluxe Desserts, Waffles & Milkshakes',
                'description' => 'Satisfy your sweet cravings with premium waffles, crepes, ice cream, chocolate cakes, and rich strawberry milkshakes.',
                'city_slug' => 'lagos-lekki',
                'address' => '45 Freedom Way, Lekki, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e',
                'banner_path' => 'https://images.unsplash.com/photo-1551024601-bec78aea704b',
                'delivery_areas' => [
                    ['town' => 'Lekki', 'fee' => 500],
                    ['town' => 'Victoria Island', 'fee' => 800],
                    ['town' => 'Ikoyi', 'fee' => 800],
                ]
            ],
            [
                'owner_email' => 'grill.house@menumenu.com',
                'name' => 'Grill House & Barbecue',
                'slug' => 'grill-house',
                'tagline' => 'Smoked Barbecue Ribs & Chicken Wings',
                'description' => 'Slow-smoked barbecue ribs, glazed honey chicken wings, and loaded fries. Perfect for lunch or your weekend game night.',
                'city_slug' => 'lagos-lekki',
                'address' => 'Plot 8, Providence St, Lekki Phase 1, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1527661591475-527312dd65f5',
                'banner_path' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1',
                'delivery_areas' => [
                    ['town' => 'Lekki', 'fee' => 600],
                    ['town' => 'Victoria Island', 'fee' => 800],
                    ['town' => 'Ajah', 'fee' => 800],
                ]
            ],
            [
                'owner_email' => 'jollof.junction@menumenu.com',
                'name' => 'Jollof Junction',
                'slug' => 'jollof-junction',
                'tagline' => 'The Ultimate Smokey Party Jollof',
                'description' => 'We do one thing and we do it perfectly: Authentic, firewood-flavored Nigerian Party Jollof Rice. Served with plantain and beef.',
                'city_slug' => 'lagos-ikeja',
                'address' => '14 Mobolaji Bank Anthony Way, Maryland, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd',
                'banner_path' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352',
                'delivery_areas' => [
                    ['town' => 'Ikeja', 'fee' => 500],
                    ['town' => 'Maryland', 'fee' => 500],
                    ['town' => 'Ojota', 'fee' => 700],
                    ['town' => 'Yaba', 'fee' => 900],
                ]
            ],
            [
                'owner_email' => 'bites.bakes@menumenu.com',
                'name' => 'Bites & Bakes Cafe',
                'slug' => 'bites-and-bakes',
                'tagline' => 'Gourmet Burgers, Sandwiches & Fries',
                'description' => 'Premium beef burgers, toasted club sandwiches, crispy French fries, and chicken nuggets. Fast, fresh, and delicious.',
                'city_slug' => 'lagos-yaba',
                'address' => 'Kosofe Plaza, Ketu, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd',
                'banner_path' => 'https://images.unsplash.com/photo-1550547660-d9450f859349',
                'delivery_areas' => [
                    ['town' => 'Yaba', 'fee' => 500],
                    ['town' => 'Maryland', 'fee' => 700],
                    ['town' => 'Ikeja', 'fee' => 800],
                ]
            ],
            [
                'owner_email' => 'village.pot@menumenu.com',
                'name' => 'The Village Pot',
                'slug' => 'village-pot',
                'tagline' => 'Traditional Firewood Native Rice & Beans',
                'description' => 'Delivering traditional palm oil native rice (Ofada), local white rice with designer pepper stew, and rich Ewa Agoyin. Authentic village taste.',
                'city_slug' => 'lagos-ikorodu',
                'address' => '52 Sagamu Road, Ikorodu, Lagos',
                'avatar_path' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe',
                'banner_path' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061',
                'delivery_areas' => [
                    ['town' => 'Ikorodu', 'fee' => 400],
                    ['town' => 'Maryland', 'fee' => 1000],
                    ['town' => 'Ojota', 'fee' => 900],
                ]
            ]
        ];

        foreach ($kitchensData as $data) {
            $user = User::where('email', $data['owner_email'])->first();
            if (!$user) {
                continue;
            }

            $city = City::where('slug', $data['city_slug'])->first();
            $cityId = $city?->id;

            $kitchen = Kitchen::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'user_id' => $user->id,
                    'name' => $data['name'],
                    'slug' => $data['slug'],
                    'tagline' => $data['tagline'],
                    'description' => $data['description'],
                    'avatar_path' => $data['avatar_path'],
                    'banner_path' => $data['banner_path'],
                    'address' => $data['address'],
                    'is_open' => true,
                    'delivery_available' => true,
                    'pickup_available' => true,
                    'open_time' => '08:00:00',
                    'close_time' => '22:00:00',
                    'commission_percent' => 10,
                ]
            );

            // Seed kitchen team ownership pivot
            \App\Models\KitchenUser::updateOrCreate(
                ['kitchen_id' => $kitchen->id, 'user_id' => $user->id],
                [
                    'kitchen_id' => $kitchen->id,
                    'user_id' => $user->id,
                    'role' => 'owner',
                    'status' => 'accepted'
                ]
            );

            // Seed kitchen logistics (operational areas)
            foreach ($data['delivery_areas'] as $area) {
                // Find matching city ID for town or fallback
                $areaCity = City::where('name', $area['town'])->first();
                $areaCityId = $areaCity?->id ?? $cityId ?? 1;

                KitchenLogistics::updateOrCreate(
                    ['kitchen_id' => $kitchen->id, 'town' => $area['town']],
                    [
                        'kitchen_id' => $kitchen->id,
                        'city_id' => $areaCityId,
                        'town' => $area['town'],
                        'fee' => $area['fee'],
                        'min_delivery_time' => 30
                    ]
                );
            }
        }
    }
}
