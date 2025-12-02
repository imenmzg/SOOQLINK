@extends('public.layout')

@section('title', $supplier->company_name . ' - SOOQLINK')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Supplier Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $supplier->company_name }}</h1>
                    @if($supplier->isVerified())
                        <span class="px-3 py-1 text-sm rounded text-white" style="background: var(--secondary);">موثق ✓</span>
                    @endif
                    <div class="mt-4">
                        <p class="text-gray-600 mb-2">
                            <strong>التقييم:</strong> 
                            {{ number_format($supplier->average_rating, 1) }} ⭐ ({{ $supplier->total_reviews }} تقييم)
                        </p>
                        @if($supplier->wilaya)
                            <p class="text-gray-600 mb-2">
                                <strong>الولاية:</strong> {{ $supplier->wilaya }}
                            </p>
                        @endif
                        @if($supplier->company_description)
                            <p class="text-gray-700 mt-4">{{ $supplier->company_description }}</p>
                        @endif
                    </div>
                </div>
                @auth
                    @if(auth()->user()->isClient())
                        <div class="flex flex-col gap-2">
                            <a href="/client/rfqs/create?supplier={{ $supplier->id }}" 
                               class="px-6 py-2 rounded-lg font-semibold text-white text-center" 
                               style="background: var(--primary);">
                                طلب عرض سعر
                            </a>
                            <a href="/client/messages?supplier={{ $supplier->id }}" 
                               class="px-6 py-2 rounded-lg font-semibold border-2 text-center" 
                               style="border-color: var(--primary); color: var(--primary);">
                                إرسال رسالة
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Products -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-4">المنتجات</h2>
            @if($supplier->products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($supplier->products as $product)
                        <a href="{{ route('products.show', $product->slug) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                            <div class="h-48 bg-gray-200">
                                @if($product->getFirstMediaUrl('images'))
                                    <img src="{{ $product->getFirstMediaUrl('images') }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold mb-2">{{ $product->name }}</h3>
                                <p class="text-xl font-bold" style="color: var(--primary);">{{ number_format($product->price, 2) }} DZD</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">لا توجد منتجات متاحة</p>
            @endif
        </div>

        <!-- Reviews -->
        @if($supplier->reviews->count() > 0)
            <div>
                <h2 class="text-2xl font-bold mb-4">التقييمات</h2>
                <div class="space-y-4">
                    @foreach($supplier->reviews as $review)
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="font-semibold">{{ $review->client->name }}</p>
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span style="color: {{ $i <= $review->rating ? '#FFD700' : '#E5E7EB' }};">⭐</span>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            @if($review->comment)
                                <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

