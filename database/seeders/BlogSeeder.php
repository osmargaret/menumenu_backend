<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Kitchen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $postsData = [
            [
                'title' => 'The Secret to the Perfect Smoky Firewood Jollof Rice',
                'excerpt' => 'Ever wondered how local caterers achieve that perfect, smoky aroma in Party Jollof? We reveal the core techniques and ingredients.',
                'body' => "Smoky Jollof Rice is more than a dish; it's a culture. To achieve the perfect smokiness without burning the rice, you must follow three critical rules. First, utilize a heavy-bottomed cast iron pot which distributes heat evenly. Second, let the rice steam under a tight layer of foil before opening. Finally, let the bottom burn slightly at the very end to release that authentic woody aroma into the steam.",
            ],
            [
                'title' => 'How to Cook Rich, Fluffy Egusi Soup (Lumpy Style)',
                'excerpt' => 'Step-by-step guide to achieving the perfect, rich, and lumpy texture for your traditional melon seed soup.',
                'body' => "Egusi soup is loved across West Africa, but the ultimate standard is the lumpy style. Achieving this texture requires frying the egusi paste slowly in bleached palm oil before adding beef stock. Be careful not to stir too early! Let the melon seed balls set completely so they stay chunky and hold their shape alongside stockfish, tripe, and fresh spinach.",
            ],
            [
                'title' => 'Healthy Nigerian Swallow Options for Weight Management',
                'excerpt' => 'Busting the myth that swallows are unhealthy. Here are 4 highly nutritious local alternatives to traditional starch.',
                'body' => "Swallows are an essential part of our daily diet, but traditional options like fufu or poundo can be heavy in carbohydrates. If you are watching your weight or sugar levels, consider switching to Plantain Flour, Wheat Swallow, Oatmeal swallow, or even Cabbage Swallow. These options are rich in dietary fiber, low in calories, and keep you full all day.",
            ],
            [
                'title' => 'A Guide to Pairing Nigerian Pepper Soup with the Perfect Drinks',
                'excerpt' => 'From chilled Zobo to refreshing local beers, here is how to elevate your catfish or assorted meat pepper soup experience.',
                'body' => "Pepper soup is exceptionally spicy and aromatic. To complement the heat, you need drinks that either cool down the palate or enhance the herbal notes. Chilled Zobo infusion (hibiscus tea) with a dash of ginger is a fantastic non-alcoholic pairing. For beer lovers, a light local lager perfectly cuts through the heat and rich oils of catfish.",
            ]
        ];

        $kitchens = Kitchen::all();

        foreach ($kitchens as $kitchen) {
            foreach ($postsData as $index => $post) {
                // Ensure unique slug
                $title = $post['title'];
                $slug = Str::slug($title) . '-' . $kitchen->id;

                BlogPost::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'kitchen_id' => $kitchen->id,
                        'title' => $title,
                        'slug' => $slug,
                        'excerpt' => $post['excerpt'],
                        'body' => $post['body'],
                        'cover_path' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c',
                        'views' => rand(150, 2500),
                        'is_published' => true,
                        'published_at' => now(),
                    ]
                );
            }
        }
    }
}
