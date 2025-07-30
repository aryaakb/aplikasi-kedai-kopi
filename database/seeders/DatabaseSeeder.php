<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Produk Arpul Creative Compound yang detail
        $products = [
            // Signature Coffee
            [
                'name' => 'Arpul Signature Espresso',
                'category' => 'Signature',
                'description' => 'Espresso premium dengan sentuhan kreatif Arpul, rasa yang bold dan berkarakter unik.',
                'price' => 18000,
                'stock' => 100,
                'image_url' => 'https://images.unsplash.com/photo-1510707577719-ae7c14805e3a?w=400'
            ],
            [
                'name' => 'Honest Americano',
                'category' => 'Black Coffee',
                'description' => 'Americano yang jujur, pahit seperlunya, tanpa pemanis berlebihan. Untuk yang suka kopi apa adanya.',
                'price' => 22000,
                'stock' => 90,
                'image_url' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=400'
            ],
            [
                'name' => 'Straight Latte',
                'category' => 'Milk Coffee',
                'description' => 'Latte tanpa embel-embel, susu premium dengan espresso berkualitas. Creamy tapi tidak berlebihan.',
                'price' => 28000,
                'stock' => 85,
                'image_url' => 'https://images.unsplash.com/photo-1561882468-9110e03e0f78?w=400'
            ],
            [
                'name' => 'Real Cappuccino',
                'category' => 'Milk Coffee',
                'description' => 'Cappuccino seperti di Italia, foam yang sempurna, rasa kopi yang dominan. No fake foam here!',
                'price' => 26000,
                'stock' => 80,
                'image_url' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400'
            ],
            [
                'name' => 'Dark Mocha',
                'category' => 'Specialty',
                'description' => 'Mocha dengan dark chocolate Belgium, untuk yang suka manis tapi tetap berkarakter kuat.',
                'price' => 32000,
                'stock' => 70,
                'image_url' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400'
            ],
            [
                'name' => 'Cold Brew No BS',
                'category' => 'Cold Coffee',
                'description' => 'Cold brew 12 jam, smooth dan tidak asam. Dingin yang bikin melek, tanpa gula tambahan.',
                'price' => 25000,
                'stock' => 60,
                'image_url' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=400'
            ],
            [
                'name' => 'Iced Latte Classic',
                'category' => 'Cold Coffee',
                'description' => 'Es latte klasik dengan susu dingin dan espresso shot double. Refreshing tapi tetap bertenaga.',
                'price' => 30000,
                'stock' => 75,
                'image_url' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=400'
            ],
            // Pastries & Snacks
            [
                'name' => 'Honest Croissant',
                'category' => 'Pastry',
                'description' => 'Croissant butter asli, berlapis-lapis dan renyah. Dibuat fresh setiap hari tanpa pengawet.',
                'price' => 20000,
                'stock' => 50,
                'image_url' => 'https://images.unsplash.com/photo-1549903072-7e6e0bedb7fb?w=400'
            ],
            [
                'name' => 'Real Chocolate Brownie',
                'category' => 'Dessert',
                'description' => 'Brownie coklat premium yang fudgy dan rich. Untuk yang butuh happiness dalam bentuk chocolate.',
                'price' => 25000,
                'stock' => 40,
                'image_url' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=400'
            ],
            [
                'name' => 'Fresh Banana Bread',
                'category' => 'Pastry',
                'description' => 'Banana bread dengan pisang sungguhan, moist dan tidak terlalu manis. Perfect pair dengan kopi.',
                'price' => 18000,
                'stock' => 45,
                'image_url' => 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?w=400'
            ],
            [
                'name' => 'Avocado Toast',
                'category' => 'Food',
                'description' => 'Roti gandum dengan alpukat fresh, telur, dan seasoning. Healthy tapi tetap enak.',
                'price' => 35000,
                'stock' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=400'
            ],
            [
                'name' => 'Classic Sandwich',
                'category' => 'Food',
                'description' => 'Sandwich isi ayam, keju, dan sayuran fresh. Simple tapi mengenyangkan.',
                'price' => 28000,
                'stock' => 35,
                'image_url' => 'https://images.unsplash.com/photo-1553909489-cd47e0ef937f?w=400'
            ],
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(
                ['name' => $productData['name']],
                $productData
            );
        }
    }
}