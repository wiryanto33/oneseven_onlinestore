<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Beras & Biji-bijian
            [
                'category' => 'Lotion',
                'products' => [
                    [
                        'name' => 'Lotion 1',
                        'description' => 'Lotion Pemutih kulit menjaga dari sinar uv',
                        'price' => 75000,
                        'stock' => 100,
                        'weight' => 5000, // 5kg
                        'height' => 40,
                        'width' => 25,
                        'length' => 10
                    ],
                    [
                        'name' => 'Lotion 2',
                        'description' => 'Lotion Pemutih kulit menjaga dari sinar uv',
                        'price' => 89000,
                        'stock' => 50,
                        'weight' => 2500, // 2.5kg
                        'height' => 35,
                        'width' => 20,
                        'length' => 8
                    ]
                ]
            ],
            // Minyak & Mentega
            [
                'category' => 'Serum',
                'products' => [
                    [
                        'name' => 'Serum 1',
                        'description' => 'Serum untuk kulit sensitif',
                        'price' => 45000,
                        'stock' => 150,
                        'weight' => 2000, // 2L
                        'height' => 30,
                        'width' => 12,
                        'length' => 12
                    ],
                    [
                        'name' => 'Serum 2',
                        'description' => 'Serum untuk kulit sensitif',
                        'price' => 25000,
                        'stock' => 80,
                        'weight' => 500,
                        'height' => 10,
                        'width' => 8,
                        'length' => 8
                    ]
                ]
            ],
            // Gula & Pemanis
            [
                'category' => 'Masker',
                'products' => [
                    [
                        'name' => 'Masker 1',
                        'description' => 'Masker Wajah, sehat & lembut',
                        'price' => 15000,
                        'stock' => 200,
                        'weight' => 1000,
                        'height' => 20,
                        'width' => 15,
                        'length' => 8
                    ],
                    [
                        'name' => 'Masker 2',
                        'description' => 'Masker Wajah, sehat & lembut',
                        'price' => 35000,
                        'stock' => 75,
                        'weight' => 500,
                        'height' => 18,
                        'width' => 12,
                        'length' => 7
                    ]
                ]
            ],
            // Telur & Susu
            [
                'category' => 'Tonner',
                'products' => [
                    [
                        'name' => 'Toner 1',
                        'description' => 'Toner untuk kulit sensitif',
                        'price' => 28000,
                        'stock' => 100,
                        'weight' => 1000, // 1kg ±16 butir
                        'height' => 15,
                        'width' => 25,
                        'length' => 30
                    ],
                    [
                        'name' => 'Toner 2',
                        'description' => 'Toner untuk kulit sensitif',
                        'price' => 18000,
                        'stock' => 120,
                        'weight' => 1000, // 1L
                        'height' => 20,
                        'width' => 10,
                        'length' => 7
                    ]
                ]
            ],
            // Bumbu Dapur
            [
                'category' => 'Fondation',
                'products' => [
                    [
                        'name' => 'Fondation 1',
                        'description' => 'Fondation untuk kulit sensitif',
                        'price' => 5000,
                        'stock' => 300,
                        'weight' => 250,
                        'height' => 12,
                        'width' => 8,
                        'length' => 5
                    ],
                    [
                        'name' => 'Fondation 2',
                        'description' => 'Fondation untuk kulit sensitif',
                        'price' => 8000,
                        'stock' => 150,
                        'weight' => 100,
                        'height' => 10,
                        'width' => 7,
                        'length' => 4
                    ]
                ]
            ]
        ];

        foreach ($products as $categoryProducts) {
            $category = Category::where('name', $categoryProducts['category'])->first();

            foreach ($categoryProducts['products'] as $product) {
                $sku = Product::generateSku($product['name']);

                Product::create([
                    'category_id' => $category->id,
                    'name' => $product['name'],
                    'slug' => Product::generateUniqueSlug($product['name']),
                    'sku' => $sku,
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'is_active' => true,
                    'images' => [],
                    'weight' => $product['weight'],
                    'height' => $product['height'],
                    'width' => $product['width'],
                    'length' => $product['length'],
                    'has_variants' => false,
                ]);
            }
        }
    }
}
