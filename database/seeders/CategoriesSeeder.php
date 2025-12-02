<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'مواد البناء', 'slug' => 'construction-materials', 'sort_order' => 1],
            ['name' => 'الأجهزة الإلكترونية', 'slug' => 'electronics', 'sort_order' => 2],
            ['name' => 'الأثاث', 'slug' => 'furniture', 'sort_order' => 3],
            ['name' => 'الملابس والنسيج', 'slug' => 'clothing-textiles', 'sort_order' => 4],
            ['name' => 'المواد الغذائية', 'slug' => 'food-products', 'sort_order' => 5],
            ['name' => 'السيارات وقطع الغيار', 'slug' => 'automotive', 'sort_order' => 6],
            ['name' => 'الأدوات المكتبية', 'slug' => 'office-supplies', 'sort_order' => 7],
            ['name' => 'المنتجات الطبية', 'slug' => 'medical-products', 'sort_order' => 8],
            ['name' => 'المنتجات الزراعية', 'slug' => 'agricultural-products', 'sort_order' => 9],
            ['name' => 'أخرى', 'slug' => 'other', 'sort_order' => 10],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

