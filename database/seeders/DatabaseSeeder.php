<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ────────────────────────────────────────────────────────────
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@store.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name'     => 'John Doe',
            'email'    => 'john@example.com',
            'password' => Hash::make('password'),
        ]);

        // ── Store ────────────────────────────────────────────────────────────
        $store = Store::create([
            'name'        => 'Main Store',
            'slug'        => 'main-store',
            'description' => 'Your destination for quality products.',
            'status'      => 'active',
        ]);

        // ── Categories (with Picsum images) ──────────────────────────────────
        $categoriesData = [
            [
                'name'        => 'Electronics',
                'slug'        => 'electronics',
                'description' => 'Smartphones, laptops, headphones, cameras and more.',
                'image'       => 'https://picsum.photos/seed/electronics-cat/800/600',
                'status'      => 'active',
            ],
            [
                'name'        => 'Fashion',
                'slug'        => 'fashion',
                'description' => 'Clothing, shoes, bags and accessories for every style.',
                'image'       => 'https://picsum.photos/seed/fashion-cat/800/600',
                'status'      => 'active',
            ],
            [
                'name'        => 'Home & Garden',
                'slug'        => 'home-garden',
                'description' => 'Furniture, decor, kitchenware and garden essentials.',
                'image'       => 'https://picsum.photos/seed/home-garden-cat/800/600',
                'status'      => 'active',
            ],
            [
                'name'        => 'Sports & Outdoors',
                'slug'        => 'sports-outdoors',
                'description' => 'Fitness equipment, outdoor gear and sportswear.',
                'image'       => 'https://picsum.photos/seed/sports-cat/800/600',
                'status'      => 'active',
            ],
            [
                'name'        => 'Books & Media',
                'slug'        => 'books-media',
                'description' => 'Books, e-books, music, movies and digital media.',
                'image'       => 'https://picsum.photos/seed/books-cat/800/600',
                'status'      => 'active',
            ],
            [
                'name'        => 'Beauty & Care',
                'slug'        => 'beauty-care',
                'description' => 'Skincare, makeup, perfumes and personal care products.',
                'image'       => 'https://picsum.photos/seed/beauty-cat/800/600',
                'status'      => 'active',
            ],
            [
                'name'        => 'Toys & Games',
                'slug'        => 'toys-games',
                'description' => 'Educational toys, board games and outdoor play.',
                'image'       => 'https://picsum.photos/seed/toys-cat/800/600',
                'status'      => 'active',
            ],
            [
                'name'        => 'Food & Grocery',
                'slug'        => 'food-grocery',
                'description' => 'Fresh produce, pantry essentials, snacks and beverages.',
                'image'       => 'https://picsum.photos/seed/food-cat/800/600',
                'status'      => 'active',
            ],
        ];

        $categories = collect($categoriesData)->map(fn($data) => Category::create($data));

        $electronics  = $categories[0];
        $fashion      = $categories[1];
        $homeGarden   = $categories[2];
        $sports       = $categories[3];
        $books        = $categories[4];
        $beauty       = $categories[5];
        $toys         = $categories[6];
        $food         = $categories[7];

        // ── Products ─────────────────────────────────────────────────────────
        $products = [

            // Electronics (4 products)
            [
                'name'          => 'Wireless Noise-Cancelling Headphones',
                'description'   => 'Premium over-ear headphones with active noise cancellation, 30-hour battery life and crystal-clear sound. Perfect for work and travel.',
                'image'         => 'https://picsum.photos/seed/headphones-prod/600/600',
                'price'         => 149.99,
                'compare_price' => 199.99,
                'category_id'   => $electronics->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Ultra-Slim Laptop 15"',
                'description'   => 'Powerful laptop with Intel Core i7, 16GB RAM, 512GB SSD and a vibrant Full HD display. Weighs just 1.4kg.',
                'image'         => 'https://picsum.photos/seed/laptop-prod/600/600',
                'price'         => 899.00,
                'compare_price' => 1099.00,
                'category_id'   => $electronics->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Smart Watch Pro',
                'description'   => 'Feature-rich smartwatch with health monitoring, GPS, 5-day battery and a stunning AMOLED display. Water resistant to 50m.',
                'image'         => 'https://picsum.photos/seed/smartwatch-prod/600/600',
                'price'         => 249.00,
                'compare_price' => 299.00,
                'category_id'   => $electronics->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Portable Bluetooth Speaker',
                'description'   => '360-degree surround sound, 24-hour playtime, waterproof design and built-in microphone for hands-free calls.',
                'image'         => 'https://picsum.photos/seed/speaker-prod/600/600',
                'price'         => 79.99,
                'compare_price' => null,
                'category_id'   => $electronics->id,
                'status'        => 'active',
            ],

            // Fashion (4 products)
            [
                'name'          => 'Classic Slim-Fit Chinos',
                'description'   => 'Versatile slim-fit chinos in premium cotton blend. Wrinkle-resistant and available in multiple colors.',
                'image'         => 'https://picsum.photos/seed/chinos-prod/600/600',
                'price'         => 59.99,
                'compare_price' => 79.99,
                'category_id'   => $fashion->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Leather Running Sneakers',
                'description'   => 'Lightweight and breathable sneakers with memory foam insoles and durable rubber outsoles. Perfect for all-day wear.',
                'image'         => 'https://picsum.photos/seed/sneakers-prod/600/600',
                'price'         => 89.00,
                'compare_price' => 120.00,
                'category_id'   => $fashion->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Merino Wool Crew Neck Sweater',
                'description'   => 'Soft and warm merino wool sweater. Naturally odor-resistant, breathable and machine washable.',
                'image'         => 'https://picsum.photos/seed/sweater-prod/600/600',
                'price'         => 74.99,
                'compare_price' => null,
                'category_id'   => $fashion->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Minimalist Leather Backpack',
                'description'   => 'Full-grain leather backpack with padded laptop compartment, multiple pockets and adjustable straps.',
                'image'         => 'https://picsum.photos/seed/backpack-prod/600/600',
                'price'         => 129.00,
                'compare_price' => 160.00,
                'category_id'   => $fashion->id,
                'status'        => 'active',
            ],

            // Home & Garden (3 products)
            [
                'name'          => 'Ceramic Pour-Over Coffee Set',
                'description'   => 'Handcrafted ceramic pour-over coffee dripper with matching mug and stainless steel gooseneck kettle.',
                'image'         => 'https://picsum.photos/seed/coffee-set-prod/600/600',
                'price'         => 49.99,
                'compare_price' => 65.00,
                'category_id'   => $homeGarden->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Bamboo Cutting Board Set',
                'description'   => 'Set of 3 eco-friendly bamboo cutting boards in different sizes. Naturally antibacterial and easy to clean.',
                'image'         => 'https://picsum.photos/seed/cutting-board-prod/600/600',
                'price'         => 34.99,
                'compare_price' => null,
                'category_id'   => $homeGarden->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Indoor Plant Pot Collection',
                'description'   => 'Set of 4 modern ceramic plant pots in matte finish. Includes drainage holes and matching saucers.',
                'image'         => 'https://picsum.photos/seed/plant-pots-prod/600/600',
                'price'         => 44.00,
                'compare_price' => 55.00,
                'category_id'   => $homeGarden->id,
                'status'        => 'active',
            ],

            // Sports & Outdoors (3 products)
            [
                'name'          => 'Adjustable Dumbbell Set 20kg',
                'description'   => 'Space-saving adjustable dumbbell set that replaces 15 pairs of weights. Quick-adjust dial from 2kg to 20kg.',
                'image'         => 'https://picsum.photos/seed/dumbbells-prod/600/600',
                'price'         => 189.00,
                'compare_price' => 240.00,
                'category_id'   => $sports->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Non-Slip Yoga Mat',
                'description'   => 'Extra-thick 6mm eco-friendly TPE yoga mat with alignment lines. Non-slip surface and carrying strap included.',
                'image'         => 'https://picsum.photos/seed/yoga-mat-prod/600/600',
                'price'         => 39.99,
                'compare_price' => null,
                'category_id'   => $sports->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Insulated Water Bottle 1L',
                'description'   => 'Double-wall vacuum insulated stainless steel bottle. Keeps drinks cold 24h or hot 12h. Leak-proof lid.',
                'image'         => 'https://picsum.photos/seed/water-bottle-prod/600/600',
                'price'         => 29.99,
                'compare_price' => 39.99,
                'category_id'   => $sports->id,
                'status'        => 'active',
            ],

            // Books & Media (3 products)
            [
                'name'          => 'The Art of Minimalism',
                'description'   => 'A beautifully illustrated guide to living with less and finding more joy. Bestseller with over 500,000 copies sold.',
                'image'         => 'https://picsum.photos/seed/book-minimalism-prod/600/600',
                'price'         => 18.99,
                'compare_price' => 24.99,
                'category_id'   => $books->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'E-Ink Reader 7" (16GB)',
                'description'   => 'Ultra-thin e-reader with front-lit display, 6-week battery life and waterproof design. Holds 10,000 books.',
                'image'         => 'https://picsum.photos/seed/ereader-prod/600/600',
                'price'         => 129.99,
                'compare_price' => 149.99,
                'category_id'   => $books->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Language Learning Audio Course',
                'description'   => 'Complete Spanish audio course with 30 lessons, native speaker recordings and downloadable workbook.',
                'image'         => 'https://picsum.photos/seed/audio-course-prod/600/600',
                'price'         => 39.00,
                'compare_price' => null,
                'category_id'   => $books->id,
                'status'        => 'active',
            ],

            // Beauty & Care (3 products)
            [
                'name'          => 'Hyaluronic Acid Serum 30ml',
                'description'   => 'Deeply hydrating serum with 2% hyaluronic acid, vitamin C and niacinamide. Suitable for all skin types.',
                'image'         => 'https://picsum.photos/seed/serum-prod/600/600',
                'price'         => 34.99,
                'compare_price' => 45.00,
                'category_id'   => $beauty->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Natural Argan Oil Shampoo',
                'description'   => 'Sulfate-free shampoo enriched with pure argan oil and keratin. Repairs damaged hair and adds shine.',
                'image'         => 'https://picsum.photos/seed/shampoo-prod/600/600',
                'price'         => 19.99,
                'compare_price' => null,
                'category_id'   => $beauty->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Floral Eau de Parfum 50ml',
                'description'   => 'Light and fresh fragrance with notes of rose, jasmine and white musk. Long-lasting and suitable for everyday wear.',
                'image'         => 'https://picsum.photos/seed/perfume-prod/600/600',
                'price'         => 64.99,
                'compare_price' => 80.00,
                'category_id'   => $beauty->id,
                'status'        => 'active',
            ],

            // Toys & Games (3 products)
            [
                'name'          => 'Strategy Board Game — Settlers',
                'description'   => 'Award-winning strategy board game for 3-4 players. Build roads, settlements and cities. Ages 10 and up.',
                'image'         => 'https://picsum.photos/seed/boardgame-prod/600/600',
                'price'         => 44.99,
                'compare_price' => 55.00,
                'category_id'   => $toys->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'STEM Robot Building Kit',
                'description'   => 'Educational robot kit for kids 8+. Teaches coding basics through hands-on building with 200+ pieces.',
                'image'         => 'https://picsum.photos/seed/robot-kit-prod/600/600',
                'price'         => 59.99,
                'compare_price' => 75.00,
                'category_id'   => $toys->id,
                'status'        => 'active',
            ],
            [
                'name'          => '1000-Piece Landscape Puzzle',
                'description'   => 'Premium quality 1000-piece jigsaw puzzle featuring a stunning mountain landscape. Finished size 68×48cm.',
                'image'         => 'https://picsum.photos/seed/puzzle-prod/600/600',
                'price'         => 24.99,
                'compare_price' => null,
                'category_id'   => $toys->id,
                'status'        => 'active',
            ],

            // Food & Grocery (3 products)
            [
                'name'          => 'Organic Cold-Pressed Olive Oil 500ml',
                'description'   => 'Extra virgin olive oil, cold-pressed from hand-picked olives. Rich flavor, high polyphenol content.',
                'image'         => 'https://picsum.photos/seed/olive-oil-prod/600/600',
                'price'         => 16.99,
                'compare_price' => 22.00,
                'category_id'   => $food->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Specialty Coffee Beans 250g',
                'description'   => 'Single-origin Ethiopian Yirgacheffe coffee beans, light roast. Tasting notes: blueberry, jasmine, citrus.',
                'image'         => 'https://picsum.photos/seed/coffee-beans-prod/600/600',
                'price'         => 14.99,
                'compare_price' => null,
                'category_id'   => $food->id,
                'status'        => 'active',
            ],
            [
                'name'          => 'Mixed Nuts & Dried Fruits Box',
                'description'   => 'Premium selection of almonds, cashews, walnuts, dried mango and cranberries. No added sugar or preservatives.',
                'image'         => 'https://picsum.photos/seed/nuts-prod/600/600',
                'price'         => 22.50,
                'compare_price' => 28.00,
                'category_id'   => $food->id,
                'status'        => 'active',
            ],
        ];

        foreach ($products as $data) {
            Product::create(array_merge($data, ['store_id' => $store->id]));
        }
    }
}
