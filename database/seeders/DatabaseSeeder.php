<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            AdminUserSeeder::class,
            CategoriesSeeder::class,
            // SampleDataSeeder::class, // Uncomment for sample data
        ]);
    }
}

