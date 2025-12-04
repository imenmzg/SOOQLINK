<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class TranslateCategoriesContent extends Command
{
    protected $signature = 'translate:categories';
    protected $description = 'Add English and French translations to categories';

    public function handle()
    {
        $this->info('Adding category translations...');
        
        $translations = [
            'مواد البناء' => [
                'en' => 'Building Materials',
                'fr' => 'Matériaux de Construction',
            ],
            'الأجهزة الإلكترونية' => [
                'en' => 'Electronics',
                'fr' => 'Électronique',
            ],
            'الأثاث' => [
                'en' => 'Furniture',
                'fr' => 'Meubles',
            ],
            'الملابس والنسيج' => [
                'en' => 'Clothing & Textiles',
                'fr' => 'Vêtements et Textiles',
            ],
            'المواد الغذائية' => [
                'en' => 'Food Products',
                'fr' => 'Produits Alimentaires',
            ],
            'السيارات وقطع الغيار' => [
                'en' => 'Auto & Spare Parts',
                'fr' => 'Auto et Pièces',
            ],
            'الأدوات المكتبية' => [
                'en' => 'Office Supplies',
                'fr' => 'Fournitures de Bureau',
            ],
            'المنتجات الطبية' => [
                'en' => 'Medical Products',
                'fr' => 'Produits Médicaux',
            ],
            'المنتجات الزراعية' => [
                'en' => 'Agricultural Products',
                'fr' => 'Produits Agricoles',
            ],
            'أخرى' => [
                'en' => 'Other',
                'fr' => 'Autres',
            ],
        ];
        
        foreach ($translations as $arabicName => $trans) {
            $categories = Category::all();
            
            foreach ($categories as $category) {
                $currentName = $category->getTranslation('name', 'ar');
                
                if ($currentName === $arabicName) {
                    $category->setTranslation('name', 'en', $trans['en']);
                    $category->setTranslation('name', 'fr', $trans['fr']);
                    $category->save();
                    
                    $this->info("✓ Translated: {$arabicName} → {$trans['en']} / {$trans['fr']}");
                    break;
                }
            }
        }
        
        $this->info('✅ All categories translated successfully!');
        $this->info('🌍 Categories now support AR, EN, and FR');
        
        return 0;
    }
}


