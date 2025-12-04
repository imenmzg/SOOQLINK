<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class MigrateCategoriesToTranslatable extends Command
{
    protected $signature = 'migrate:translatable';
    protected $description = 'Migrate existing categories and products to translatable format';

    public function handle()
    {
        $this->info('Starting migration to translatable format...');
        
        // Migrate Categories
        $this->info('Migrating categories...');
        $categories = DB::table('categories')->get();
        
        foreach ($categories as $category) {
            // Check if name is already JSON
            if ($this->isJson($category->name)) {
                $this->warn("Category {$category->id} already migrated, skipping...");
                continue;
            }
            
            // Convert to JSON format
            $translatedName = json_encode([
                'ar' => $category->name,
                'en' => $category->name,
                'fr' => $category->name,
            ]);
            
            $translatedDescription = $category->description ? json_encode([
                'ar' => $category->description,
                'en' => $category->description,
                'fr' => $category->description,
            ]) : null;
            
            DB::table('categories')
                ->where('id', $category->id)
                ->update([
                    'name' => $translatedName,
                    'description' => $translatedDescription,
                ]);
            
            $this->info("✓ Migrated category: {$category->name}");
        }
        
        // Migrate Products
        $this->info('Migrating products...');
        $products = DB::table('products')->get();
        
        foreach ($products as $product) {
            // Check if name is already JSON
            if ($this->isJson($product->name)) {
                $this->warn("Product {$product->id} already migrated, skipping...");
                continue;
            }
            
            // Convert to JSON format
            $translatedName = json_encode([
                'ar' => $product->name,
                'en' => $product->name,
                'fr' => $product->name,
            ]);
            
            $translatedDescription = $product->description ? json_encode([
                'ar' => $product->description,
                'en' => $product->description,
                'fr' => $product->description,
            ]) : null;
            
            $translatedTechnicalDetails = $product->technical_details ? json_encode([
                'ar' => $product->technical_details,
                'en' => $product->technical_details,
                'fr' => $product->technical_details,
            ]) : null;
            
            DB::table('products')
                ->where('id', $product->id)
                ->update([
                    'name' => $translatedName,
                    'description' => $translatedDescription,
                    'technical_details' => $translatedTechnicalDetails,
                ]);
            
            $this->info("✓ Migrated product: {$product->name}");
        }
        
        $this->info('✅ Migration complete!');
        $this->info('📝 Now you can add English and French translations through the admin panel.');
        
        return 0;
    }
    
    private function isJson($string)
    {
        if (!is_string($string)) {
            return false;
        }
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
