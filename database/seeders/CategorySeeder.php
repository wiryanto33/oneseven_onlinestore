<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Lotion',
                'image' => null
            ],
            [
                'name' => 'Serum',
                'image' => null
            ],
            [
                'name' => 'Masker',
                'image' => null
            ],
            [
                'name' => 'Tonner',
                'image' => null
            ],
            [
                'name' => 'Fondation',
                'image' => null
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Category::generateUniqueSlug($category['name']),
                'image' => $category['image']
            ]);
        }
    }
}
