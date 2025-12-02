@extends('public.layout')

@section('title', 'المنتجات - SOOQLINK')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    <!-- Hero Header -->
    <div class="relative bg-gradient-to-br overflow-hidden" style="background: linear-gradient(to bottom right, rgba(50, 167, 226, 0.08), white, rgba(111, 194, 66, 0.05));">
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, #32A7E2 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/80 backdrop-blur-sm text-sm font-semibold mb-6 shadow-lg border-2" style="color: #32A7E2; border-color: rgba(50, 167, 226, 0.3);">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    منتجات عالية الجودة
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-slate-900 mb-4">
                    <span style="color: #32A7E2;">المنتجات</span> المتاحة
                </h1>
                <p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto">
                    @if($products->count() > 0)
                        اكتشف {{ $products->count() }} منتج متاح من موردين موثوقين
                    @else
                        ابدأ بإضافة منتجاتك الأولى
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Filters Sidebar -->
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-24">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5" style="color: #32A7E2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            الفلاتر
                        </h3>
                        <button onclick="resetFilters()" class="text-sm font-semibold transition-colors hover:underline" style="color: #32A7E2;">
                            إعادة تعيين
                        </button>
                    </div>
                    
                    <form method="GET" action="{{ route('products.index') }}" id="filterForm" class="space-y-6">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-slate-700">البحث</label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="ابحث عن منتج..." 
                                    class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 pr-10 focus:outline-none transition-all text-sm"
                                    style="border-color: rgb(226, 232, 240);"
                                    onfocus="this.style.borderColor='#32A7E2'; this.style.boxShadow='0 0 0 3px rgba(50, 167, 226, 0.1)';"
                                    onblur="this.style.borderColor='rgb(226, 232, 240)'; this.style.boxShadow='none';"
                                >
                                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-slate-700">الفئة</label>
                            <select name="category" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-[#32A7E2] focus:ring-2 focus:ring-[#32A7E2] focus:ring-opacity-20 focus:outline-none transition-all text-sm">
                                <option value="">جميع الفئات</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Wilaya -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-slate-700">الولاية</label>
                            <select name="wilaya" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-[#32A7E2] focus:ring-2 focus:ring-[#32A7E2] focus:ring-opacity-20 focus:outline-none transition-all text-sm">
                                <option value="">جميع الولايات</option>
                                @foreach($wilayas as $wilaya)
                                    <option value="{{ $wilaya }}" {{ request('wilaya') == $wilaya ? 'selected' : '' }}>
                                        {{ $wilaya }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-slate-700">نطاق السعر (DZD)</label>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <input 
                                        type="number" 
                                        name="min_price" 
                                        placeholder="من" 
                                        value="{{ request('min_price') }}" 
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-[#32A7E2] focus:ring-2 focus:ring-[#32A7E2] focus:ring-opacity-20 focus:outline-none transition-all text-sm"
                                    >
                                </div>
                                <div>
                                    <input 
                                        type="number" 
                                        name="max_price" 
                                        placeholder="إلى" 
                                        value="{{ request('max_price') }}" 
                                        class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-[#32A7E2] focus:ring-2 focus:ring-[#32A7E2] focus:ring-opacity-20 focus:outline-none transition-all text-sm"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label class="block text-sm font-bold mb-2 text-slate-700">ترتيب حسب</label>
                            <select name="sort" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-[#32A7E2] focus:ring-2 focus:ring-[#32A7E2] focus:ring-opacity-20 focus:outline-none transition-all text-sm">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>السعر: منخفض إلى مرتفع</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>السعر: مرتفع إلى منخفض</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>الأعلى تقييماً</option>
                            </select>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full py-3.5 rounded-xl text-white font-bold transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                            style="background: linear-gradient(135deg, #32A7E2, #2B96D1);"
                        >
                            تطبيق الفلاتر
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="productsGrid">
                        @foreach($products as $product)
                            <a 
                                href="{{ route('products.show', $product->slug) }}" 
                                class="group bg-white rounded-2xl overflow-hidden border-2 border-gray-100 hover:border-[#32A7E2] hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1"
                                style="box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);"
                            >
                                <!-- Product Image -->
                                <div class="relative h-48 bg-gradient-to-br overflow-hidden" style="background: linear-gradient(135deg, rgba(50, 167, 226, 0.1), rgba(111, 194, 66, 0.05));">
                                    @if($product->getFirstMediaUrl('images'))
                                        <img 
                                            src="{{ $product->getFirstMediaUrl('images') }}" 
                                            alt="{{ $product->name }}" 
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        >
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Badges -->
                                    <div class="absolute top-3 left-3 flex flex-col gap-2">
                                        @if($product->supplier && $product->supplier->isVerified())
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold text-white shadow-lg" style="background: linear-gradient(135deg, #6FC242, #5db336);">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                موثق
                                            </div>
                                        @endif
                                        @if($product->quantity > 0)
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold text-white shadow-lg" style="background: linear-gradient(135deg, #6FC242, #5db336);">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                متوفر
                                            </div>
                                        @else
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold text-white shadow-lg bg-red-500">
                                                غير متوفر
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if($product->supplier && $product->supplier->average_rating > 0)
                                        <div class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-2.5 py-1.5 rounded-lg flex items-center gap-1.5 shadow-lg">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-xs font-bold text-slate-900">{{ number_format($product->supplier->average_rating, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Product Info -->
                                <div class="p-5">
                                    <h3 class="font-bold text-lg mb-3 text-slate-900 line-clamp-2 group-hover:text-[#32A7E2] transition-colors min-h-[3.5rem]">
                                        {{ $product->name }}
                                    </h3>
                                    
                                    <!-- Supplier -->
                                    <div class="flex items-center gap-2 mb-4">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold text-white" style="background: linear-gradient(135deg, #32A7E2, #2B96D1);">
                                            {{ substr($product->supplier->company_name ?? 'N', 0, 1) }}
                                        </div>
                                        <p class="text-sm text-gray-600 truncate font-medium">{{ $product->supplier->company_name ?? 'N/A' }}</p>
                                    </div>
                                    
                                    <!-- Price and Location -->
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <p class="text-2xl font-bold" style="color: #32A7E2;">
                                                {{ number_format($product->price, 0) }} 
                                                <span class="text-sm text-gray-500 font-normal">DZD</span>
                                            </p>
                                        </div>
                                        
                                        @if($product->wilaya)
                                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                {{ $product->wilaya }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Load More / Pagination -->
                    <div class="mt-12 flex justify-center">
                        @if($products->hasMorePages())
                            <button 
                                id="loadMore" 
                                class="px-8 py-3.5 rounded-xl font-bold text-white transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                                style="background: linear-gradient(135deg, #32A7E2, #2B96D1);"
                            >
                                تحميل المزيد
                            </button>
                        @endif
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-16 text-center">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, rgba(50, 167, 226, 0.1), rgba(111, 194, 66, 0.1));">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3">لا توجد منتجات</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">لم نجد منتجات تطابق معايير البحث الخاصة بك. جرب تغيير الفلاتر أو البحث عن شيء آخر.</p>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl font-bold text-white transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5" style="background: linear-gradient(135deg, #32A7E2, #2B96D1);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            عرض جميع المنتجات
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function resetFilters() {
        window.location.href = '{{ route("products.index") }}';
    }

    let nextCursor = '{{ $products->nextCursor()?->encode() }}';
    const loadMoreBtn = document.getElementById('loadMore');
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', async function() {
            if (!nextCursor) return;
            
            loadMoreBtn.textContent = 'جاري التحميل...';
            loadMoreBtn.disabled = true;
            
            const params = new URLSearchParams(window.location.search);
            params.set('cursor', nextCursor);
            
            try {
                const response = await fetch(`/api/products?${params.toString()}`);
                const data = await response.json();
                
                const grid = document.getElementById('productsGrid');
                data.data.forEach(product => {
                    const productHtml = `
                        <a href="/products/${product.slug}" class="group bg-white rounded-2xl overflow-hidden border-2 border-gray-100 hover:border-[#32A7E2] hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative h-48 bg-gradient-to-br overflow-hidden" style="background: linear-gradient(135deg, rgba(50, 167, 226, 0.1), rgba(111, 194, 66, 0.05));">
                                ${product.images && product.images.length > 0 ? 
                                    `<img src="${product.images[0]}" alt="${product.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">` :
                                    `<div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>`
                                }
                            </div>
                            <div class="p-5">
                                <h3 class="font-bold text-lg mb-3 text-slate-900 line-clamp-2">${product.name}</h3>
                                <p class="text-sm mb-3 text-gray-600">${product.supplier?.company_name || ''}</p>
                                <p class="text-2xl font-bold" style="color: #32A7E2;">${parseFloat(product.price).toFixed(0)} <span class="text-sm text-gray-500 font-normal">DZD</span></p>
                            </div>
                        </a>
                    `;
                    grid.insertAdjacentHTML('beforeend', productHtml);
                });
                
                nextCursor = data.next_cursor;
                if (!data.has_more) {
                    loadMoreBtn.remove();
                } else {
                    loadMoreBtn.textContent = 'تحميل المزيد';
                    loadMoreBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error loading more products:', error);
                loadMoreBtn.textContent = 'خطأ في التحميل';
            }
        });
    }
</script>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    #productsGrid > a {
        animation: fadeInUp 0.5s ease-out;
        animation-fill-mode: both;
    }
    
    #productsGrid > a:nth-child(1) { animation-delay: 0.1s; }
    #productsGrid > a:nth-child(2) { animation-delay: 0.2s; }
    #productsGrid > a:nth-child(3) { animation-delay: 0.3s; }
    #productsGrid > a:nth-child(4) { animation-delay: 0.4s; }
    #productsGrid > a:nth-child(5) { animation-delay: 0.5s; }
    #productsGrid > a:nth-child(6) { animation-delay: 0.6s; }
</style>
@endsection
