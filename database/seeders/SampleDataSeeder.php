<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Category;
use App\Models\RFQ;
use App\Models\RFQReply;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample suppliers
        $suppliers = [];
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "مورد {$i}",
                'email' => "supplier{$i}@example.com",
                'password' => Hash::make('password'),
                'phone' => "05" . rand(10000000, 99999999),
                'type' => 'supplier',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
            $user->assignRole('supplier');

            $supplier = Supplier::create([
                'user_id' => $user->id,
                'company_name' => "شركة المورد {$i}",
                'company_description' => "وصف شركة المورد {$i}",
                'wilaya' => ['الجزائر', 'وهران', 'قسنطينة', 'عنابة', 'باتنة'][rand(0, 4)],
                'location' => "موقع {$i}",
                'verification_status' => $i <= 3 ? 'verified' : 'pending',
                'verified_at' => $i <= 3 ? now() : null,
                'is_active' => true,
            ]);

            $suppliers[] = $supplier;
        }

        // Create sample clients
        $clients = [];
        for ($i = 1; $i <= 3; $i++) {
            $user = User::create([
                'name' => "عميل {$i}",
                'email' => "client{$i}@example.com",
                'password' => Hash::make('password'),
                'phone' => "05" . rand(10000000, 99999999),
                'type' => 'client',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
            $user->assignRole('client');
            $clients[] = $user;
        }

        // Create sample products
        $categories = Category::all();
        foreach ($suppliers as $supplier) {
            if ($supplier->isVerified()) {
                for ($j = 1; $j <= rand(3, 8); $j++) {
                    $category = $categories->random();
                    Product::create([
                        'supplier_id' => $supplier->id,
                        'category_id' => $category->id,
                        'name' => "منتج {$j} - {$supplier->company_name}",
                        'description' => "وصف المنتج {$j}",
                        'technical_details' => "تفاصيل تقنية للمنتج {$j}",
                        'price' => rand(1000, 50000),
                        'quantity' => rand(10, 100),
                        'wilaya' => $supplier->wilaya,
                        'location' => $supplier->location,
                        'is_published' => true,
                    ]);
                }
            }
        }

        // Create sample RFQs
        foreach ($clients as $client) {
            foreach ($suppliers->where('verification_status', 'verified') as $supplier) {
                if (rand(0, 1)) {
                    $product = Product::where('supplier_id', $supplier->id)->inRandomOrder()->first();
                    $rfq = RFQ::create([
                        'client_id' => $client->id,
                        'supplier_id' => $supplier->id,
                        'product_id' => $product?->id,
                        'subject' => "طلب عرض سعر - {$product?->name ?? 'منتج عام'}",
                        'description' => "أرغب في الحصول على عرض سعر لهذا المنتج",
                        'quantity' => rand(10, 100),
                        'status' => ['sent', 'replied', 'accepted'][rand(0, 2)],
                    ]);

                    // Create RFQ reply if status is replied or accepted
                    if (in_array($rfq->status, ['replied', 'accepted'])) {
                        $reply = RFQReply::create([
                            'rfq_id' => $rfq->id,
                            'supplier_id' => $supplier->id,
                            'price' => rand(500, 5000),
                            'message' => "نقدم لكم أفضل عرض سعر",
                            'delivery_date' => now()->addDays(rand(7, 30)),
                            'is_accepted' => $rfq->status === 'accepted',
                        ]);
                        $rfq->markAsReplied();
                    }
                }
            }
        }

        // Create sample reviews
        foreach ($clients as $client) {
            foreach ($suppliers->where('verification_status', 'verified') as $supplier) {
                $rfq = RFQ::where('client_id', $client->id)
                    ->where('supplier_id', $supplier->id)
                    ->whereIn('status', ['replied', 'accepted'])
                    ->first();

                if ($rfq && rand(0, 1)) {
                    Review::create([
                        'client_id' => $client->id,
                        'supplier_id' => $supplier->id,
                        'rfq_id' => $rfq->id,
                        'rating' => rand(3, 5),
                        'comment' => "تجربة رائعة مع هذا المورد",
                        'is_approved' => true,
                    ]);
                }
            }
        }

        // Update supplier ratings
        foreach ($suppliers as $supplier) {
            $supplier->updateRating();
        }
    }
}

