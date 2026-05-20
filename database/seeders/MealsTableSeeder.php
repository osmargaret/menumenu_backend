<?php

namespace Database\Seeders;

use App\Models\Meal;
use App\Models\Kitchen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MealsTableSeeder extends Seeder
{
    public function run(): void
    {
        $mealsData = [
            'mama-t' => [
                [
                    'name' => 'Egusi Soup with Semovita',
                    'description' => 'Rich melon seed soup cooked with spinach, stockfish, and assorted beef, served with hot Semovita swallow.',
                    'price' => 3500,
                    'prep_time' => 25,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c'
                ],
                [
                    'name' => 'Efo Riro with Pounded Yam',
                    'description' => 'Traditional Yoruba rich vegetable soup cooked in palm oil with locust beans, tripe, and beef, served with hot pounded yam swallow.',
                    'price' => 4000,
                    'prep_time' => 30,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c'
                ],
                [
                    'name' => 'Abula (Amala, Gbegiri & Ewedu)',
                    'description' => 'Soft Yam Flour swallow served with local bean soup (gbegiri), jute leaves (ewedu), and spicy pepper sauce with assorted meat.',
                    'price' => 3000,
                    'prep_time' => 20,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c'
                ],
                [
                    'name' => 'Assorted Meat Pepper Soup',
                    'description' => 'Spicy and aromatic Nigerian soup brewed with local spices, ginger, garlic, and tender assorted beef parts.',
                    'price' => 3500,
                    'prep_time' => 15,
                    'category' => 'Sides',
                    'image_path' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c'
                ]
            ],
            'oven-fresh' => [
                [
                    'name' => 'Gourmet Beef Meat Pie',
                    'description' => 'Crispy, buttery shortcrust pastry filled with perfectly seasoned minced beef, potatoes, and carrots.',
                    'price' => 800,
                    'prep_time' => 10,
                    'category' => 'Breakfast',
                    'image_path' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90'
                ],
                [
                    'name' => 'Gourmet Chicken Pie',
                    'description' => 'Crispy, buttery shortcrust pastry filled with minced chicken breasts, carrots, and sweet cream sauce.',
                    'price' => 900,
                    'prep_time' => 10,
                    'category' => 'Breakfast',
                    'image_path' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90'
                ],
                [
                    'name' => 'Fresh Agege Bread',
                    'description' => 'Soft, stretchy, and freshly baked traditional Nigerian sweet bread, perfect with butter or Ewa Agoyin.',
                    'price' => 500,
                    'prep_time' => 5,
                    'category' => 'Sides',
                    'image_path' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff'
                ],
                [
                    'name' => 'Glazed Jam Donuts (Pack of 4)',
                    'description' => 'Fluffy, yeast-raised donuts fried golden brown and loaded with sweet strawberry jam filling.',
                    'price' => 2000,
                    'prep_time' => 10,
                    'category' => 'Dessert',
                    'image_path' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff'
                ]
            ],
            'spice-palace' => [
                [
                    'name' => 'Smoky Party Jollof Rice',
                    'description' => 'Firewood-flavored smoky long-grain Jollof rice served with sweet fried plantain (dodo) and spicy peppered chicken.',
                    'price' => 3800,
                    'prep_time' => 20,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092'
                ],
                [
                    'name' => 'Special Fried Rice',
                    'description' => 'Fragrant fried rice loaded with sweet corn, carrots, green beans, liver chunks, served with dodo and grilled beef.',
                    'price' => 4000,
                    'prep_time' => 20,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092'
                ],
                [
                    'name' => 'Coconut Rice with Fried Croaker',
                    'description' => 'Rich, sweet coconut milk infused rice served with spicy stewed Croaker fish and plantain.',
                    'price' => 4500,
                    'prep_time' => 25,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092'
                ],
                [
                    'name' => 'Fried Sweet Plantain (Dodo) Side',
                    'description' => 'A portion of golden, perfectly caramelized fried ripe Nigerian plantain.',
                    'price' => 800,
                    'prep_time' => 10,
                    'category' => 'Sides',
                    'image_path' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092'
                ]
            ],
            'suya-republic' => [
                [
                    'name' => 'Standard Beef Suya',
                    'description' => 'Spicy, perfectly skewered and grilled flank steak, seasoned with northern yaji spice, onions, and cabbage.',
                    'price' => 1500,
                    'prep_time' => 15,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1544025162-d76694265947'
                ],
                [
                    'name' => 'Special Ram Suya',
                    'description' => 'Gourmet, exceptionally tender ram meat seasoned with signature suya spices and grilled over hot coals.',
                    'price' => 2500,
                    'prep_time' => 20,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1544025162-d76694265947'
                ],
                [
                    'name' => 'Spicy Grilled Chicken Suya',
                    'description' => 'Boneless chicken breast strips marinated in hot peanut suya sauce and grilled to juicy perfection.',
                    'price' => 2000,
                    'prep_time' => 15,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1544025162-d76694265947'
                ],
                [
                    'name' => 'Tozo (Fatty Beef Suya)',
                    'description' => 'Mouthwatering, fatty cut of northern beef suya, rich in flavor and spices.',
                    'price' => 1800,
                    'prep_time' => 15,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1544025162-d76694265947'
                ]
            ],
            'morning-glory' => [
                [
                    'name' => 'Fluffy Pancakes with Syrup',
                    'description' => 'Three thick, golden American-style pancakes served with pure maple syrup and butter.',
                    'price' => 2500,
                    'prep_time' => 15,
                    'category' => 'Breakfast',
                    'image_path' => 'https://images.unsplash.com/photo-1498804103079-a6351b050096'
                ],
                [
                    'name' => 'Classic Toast & Scrambled Eggs',
                    'description' => 'Two slices of buttered golden toast served with fluffy milk-scrambled eggs and grilled tomatoes.',
                    'price' => 1800,
                    'prep_time' => 12,
                    'category' => 'Breakfast',
                    'image_path' => 'https://images.unsplash.com/photo-1498804103079-a6351b050096'
                ],
                [
                    'name' => 'Fried Plantain & Egg Sauce',
                    'description' => 'Golden fried sweet plantains served with a rich, colorful tomato and onion egg scramble sauce.',
                    'price' => 2200,
                    'prep_time' => 15,
                    'category' => 'Breakfast',
                    'image_path' => 'https://images.unsplash.com/photo-1498804103079-a6351b050096'
                ],
                [
                    'name' => 'Fresh Orange Juice Glass',
                    'description' => '100% natural, freshly squeezed sweet Nigerian oranges, served chilled.',
                    'price' => 1200,
                    'prep_time' => 5,
                    'category' => 'Drinks',
                    'image_path' => 'https://images.unsplash.com/photo-1498804103079-a6351b050096'
                ]
            ],
            'ocean-catch' => [
                [
                    'name' => 'Point-and-Kill Catfish Pepper Soup',
                    'description' => 'Fresh catfish simmered in a very hot and spicy local broth made with utazi, uziza, and local pepper soup seeds.',
                    'price' => 5000,
                    'prep_time' => 30,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb'
                ],
                [
                    'name' => 'Spicy Grilled Croaker Fish',
                    'description' => 'Whole large Croaker fish, seasoned with signature spicy marinade, grilled over slow fire, served with golden fries.',
                    'price' => 6500,
                    'prep_time' => 40,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2'
                ],
                [
                    'name' => 'Special Seafood Okra Soup',
                    'description' => 'Rich, slimy chopped local okra loaded with fresh prawns, crab claws, catfish, calamari, and periwinkles.',
                    'price' => 4500,
                    'prep_time' => 30,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb'
                ]
            ],
            'naija-swallow' => [
                [
                    'name' => 'Poundo Yam with White Soup (Nsala)',
                    'description' => 'Nsala (Ofe Nsala) is a tasty local catfish soup thickened with yam and flavored with utazi, served with hot poundo swallow.',
                    'price' => 4500,
                    'prep_time' => 30,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836'
                ],
                [
                    'name' => 'Amala with Ewedu & Gbegiri',
                    'description' => 'Soft, warm Yam Flour swallow served with Ewedu leaf sauce, Gbegiri bean sauce, and rich peppered beef stew.',
                    'price' => 3000,
                    'prep_time' => 20,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836'
                ],
                [
                    'name' => 'Wheat Swallow with Bitterleaf Soup',
                    'description' => 'Traditional bitterleaf soup cooked with cocoa yam paste, palm oil, stockfish, served with healthy wheat swallow.',
                    'price' => 3500,
                    'prep_time' => 30,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836'
                ]
            ],
            'sweet-tooth' => [
                [
                    'name' => 'Belgian Chocolate Waffles',
                    'description' => 'Warm, golden Belgian waffles topped with hot chocolate sauce, fresh banana slices, and whipped cream.',
                    'price' => 3000,
                    'prep_time' => 15,
                    'category' => 'Dessert',
                    'image_path' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e'
                ],
                [
                    'name' => 'Sweet Strawberry Crepes',
                    'description' => 'Two thin french-style crepes filled with fresh strawberry chunks and topped with strawberry jam glaze.',
                    'price' => 2800,
                    'prep_time' => 15,
                    'category' => 'Dessert',
                    'image_path' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e'
                ],
                [
                    'name' => 'Oreo Cookie Milkshake',
                    'description' => 'Thick, creamy milkshake blended with Oreo cookies, vanilla ice cream, and topped with chocolate crumbles.',
                    'price' => 2200,
                    'prep_time' => 8,
                    'category' => 'Drinks',
                    'image_path' => 'https://images.unsplash.com/photo-1551024601-bec78aea704b'
                ]
            ],
            'grill-house' => [
                [
                    'name' => 'Honey BBQ Chicken Wings',
                    'description' => 'Six pieces of slow-grilled juicy chicken wings coated in sweet honey barbecue glaze, served with coleslaw.',
                    'price' => 4000,
                    'prep_time' => 20,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1'
                ],
                [
                    'name' => 'Loaded Cheesy Beef Fries',
                    'description' => 'Golden French fries loaded with spicy minced beef, liquid cheddar cheese, and signature house burger sauce.',
                    'price' => 3500,
                    'prep_time' => 18,
                    'category' => 'Sides',
                    'image_path' => 'https://images.unsplash.com/photo-1527661591475-527312dd65f5'
                ],
                [
                    'name' => 'Grilled T-Bone Steak',
                    'description' => 'Juicy T-Bone steak marinated in garlic and herbs, flame-grilled to medium-well, served with roasted potatoes.',
                    'price' => 9000,
                    'prep_time' => 35,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1'
                ]
            ],
            'jollof-junction' => [
                [
                    'name' => 'Original Firewood Jollof Rice',
                    'description' => 'Traditional, smoky firewood-cooked Jollof rice served with fried sweet plantain (dodo) and boiled peppered egg.',
                    'price' => 3000,
                    'prep_time' => 15,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd'
                ],
                [
                    'name' => 'Jollof Rice with Grilled Turkey',
                    'description' => 'Smoky firewood Jollof rice paired with a huge, golden fried peppered turkey wing and sweet plantain.',
                    'price' => 4500,
                    'prep_time' => 20,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd'
                ],
                [
                    'name' => 'Jollof Rice with Peppered Beef',
                    'description' => 'Perfectly cooked firewood Jollof rice served with two pieces of stewed peppered beef and dodo.',
                    'price' => 3500,
                    'prep_time' => 18,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd'
                ]
            ],
            'bites-and-bakes' => [
                [
                    'name' => 'Classic Double Beef Burger',
                    'description' => 'Two flame-grilled beef patties with cheddar cheese, lettuce, tomatoes, and home burger sauce in toasted brioche buns.',
                    'price' => 3500,
                    'prep_time' => 18,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd'
                ],
                [
                    'name' => 'Crispy Chicken Burger',
                    'description' => 'Golden fried buttermilk chicken breast topped with spicy mayo and sweet pickles in brioche buns.',
                    'price' => 3200,
                    'prep_time' => 15,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd'
                ],
                [
                    'name' => 'Toasted Club Sandwich',
                    'description' => 'Triple decker toast with chicken mayo filling, boiled eggs, tomatoes, lettuce, served with chips.',
                    'price' => 2500,
                    'prep_time' => 15,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd'
                ]
            ],
            'village-pot' => [
                [
                    'name' => 'Ofada Rice with Designer Stew',
                    'description' => 'Aromatic unpolished local Ofada rice served in leaf with spicy, peppered bleached palm oil stew, boiled egg, and beef.',
                    'price' => 3800,
                    'prep_time' => 25,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe'
                ],
                [
                    'name' => 'Native Palm Oil Rice with Fish',
                    'description' => 'Delicious local rice cooked in palm oil with locust beans (iru), dried fish, and crayfish, served with fried croaker.',
                    'price' => 3200,
                    'prep_time' => 20,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe'
                ],
                [
                    'name' => 'Sweet Ewa Agoyin & Fried Bread',
                    'description' => 'Mashy mashed beans served with authentic spicy, dark palm oil Agoyin sauce, paired with warm fried Agege bread.',
                    'price' => 2000,
                    'prep_time' => 15,
                    'category' => 'Main',
                    'image_path' => 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe'
                ]
            ]
        ];

        foreach ($mealsData as $kitchenSlug => $meals) {
            $kitchen = Kitchen::where('slug', $kitchenSlug)->first();
            if (!$kitchen) {
                continue;
            }

            foreach ($meals as $meal) {
                Meal::updateOrCreate(
                    ['kitchen_id' => $kitchen->id, 'name' => $meal['name']],
                    [
                        'kitchen_id' => $kitchen->id,
                        'name' => $meal['name'],
                        'slug' => Str::slug($meal['name']) . '-' . rand(100, 999),
                        'description' => $meal['description'],
                        'price' => $meal['price'],
                        'currency' => 'NGN',
                        'available' => true,
                        'prep_time' => $meal['prep_time'],
                        'category' => $meal['category'],
                        'image_path' => $meal['image_path']
                    ]
                );
            }
        }
    }
}
