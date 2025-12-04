@extends('public.layout')

@section('title', $product->name . ' - SOOQLINK')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white">
    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#32A7E2] transition-colors">{{ __('products.breadcrumb_home') }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-[#32A7E2] transition-colors">{{ __('products.breadcrumb_products') }}</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="text-gray-900 font-medium">{{ Str::limit($product->name, 50) }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Images -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="relative h-[500px] bg-gradient-to-br" style="background: linear-gradient(135deg, rgba(50, 167, 226, 0.05), rgba(111, 194, 66, 0.02));">
                        @if($product->getFirstMediaUrl('images'))
                            <img 
                                id="mainImage"
                                src="{{ $product->getFirstMediaUrl('images') }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-full object-contain p-8"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            @if($product->supplier && $product->supplier->isVerified())
                                <div class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-bold text-white shadow-lg" style="background: linear-gradient(135deg, #6FC242, #5db336);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('products.verified_supplier') }}
                                </div>
                            @endif
                            @if($product->quantity > 0)
                                <div class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-bold text-white shadow-lg" style="background: linear-gradient(135deg, #6FC242, #5db336);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('products.available') }}
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-sm font-bold text-white shadow-lg bg-red-500">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('common.unavailable') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Thumbnail Gallery -->
                @if($product->getMedia('images')->count() > 1)
                    <div class="grid grid-cols-4 gap-3">
                        @foreach($product->getMedia('images') as $image)
                            <button 
                                onclick="changeMainImage('{{ $image->getUrl() }}')"
                                class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#32A7E2] overflow-hidden transition-all shadow-sm hover:shadow-md"
                            >
                                <img src="{{ $image->getUrl() }}" alt="{{ $product->name }}" class="w-full h-24 object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="space-y-6">
                <!-- Product Info Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-6 leading-tight">
                        {{ $product->name }}
                    </h1>
                    
                    <!-- Price -->
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-bold" style="color: #32A7E2;">{{ number_format($product->price, 0) }}</span>
                            <span class="text-xl text-gray-500 font-medium">DZD</span>
                        </div>
                    </div>

                    <!-- Product Meta -->
                    <div class="space-y-4 mb-6">
                        <!-- Supplier -->
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, rgba(50, 167, 226, 0.1), rgba(50, 167, 226, 0.05));">
                                <svg class="w-5 h-5" style="color: #32A7E2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 mb-0.5">{{ __('products.supplier') }}</div>
                                <a href="{{ route('supplier.show', $product->supplier->id) }}" class="text-base font-bold hover:text-[#32A7E2] transition-colors flex items-center gap-2">
                                {{ $product->supplier->company_name }}
                                    @if($product->supplier->isVerified())
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg text-xs font-bold text-white" style="background: linear-gradient(135deg, #6FC242, #5db336);">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            موثق
                                        </span>
                                    @endif
                                </a>
                            </div>
                        </div>

                        <!-- Rating -->
                        @if($product->supplier->average_rating > 0)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-yellow-50">
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 mb-0.5">{{ __('products.rating') }}</div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-base font-bold text-slate-900">{{ number_format($product->supplier->average_rating, 1) }}</span>
                                        <div class="flex items-center gap-0.5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= round($product->supplier->average_rating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-500">({{ $product->supplier->total_reviews }} تقييم)</span>
                                    </div>
                                </div>
                            </div>
                            @endif

                        <!-- Category -->
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, rgba(111, 194, 66, 0.1), rgba(111, 194, 66, 0.05));">
                                <svg class="w-5 h-5" style="color: #6FC242;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 mb-0.5">{{ __('products.category') }}</div>
                                <div class="text-base font-bold text-slate-900">{{ $product->category->name }}</div>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, rgba(50, 167, 226, 0.1), rgba(50, 167, 226, 0.05));">
                                <svg class="w-5 h-5" style="color: #32A7E2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 mb-0.5">{{ __('products.available_quantity') }}</div>
                                <div class="text-base font-bold text-slate-900">{{ $product->quantity }} {{ __('products.unit') }}</div>
                            </div>
                        </div>

                        <!-- Location -->
                        @if($product->wilaya)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, rgba(50, 167, 226, 0.1), rgba(50, 167, 226, 0.05));">
                                    <svg class="w-5 h-5" style="color: #32A7E2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 mb-0.5">{{ __('products.wilaya') }}</div>
                                    <div class="text-base font-bold text-slate-900">{{ $product->wilaya }}</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                    @auth
                        @if(auth()->user()->isClient())
                            <a href="/client/rfqs/create?supplier={{ $product->supplier->id }}&product={{ $product->id }}" 
                                   class="flex items-center justify-center gap-2 w-full px-6 py-4 rounded-xl font-bold text-white transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5" 
                                   style="background: linear-gradient(135deg, #32A7E2, #2B96D1);">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                {{ __('products.request_quote') }}
                            </a>
                            <a href="/client/messages?supplier={{ $product->supplier->id }}" 
                                   class="flex items-center justify-center gap-2 w-full px-6 py-4 rounded-xl font-bold border-2 transition-all hover:shadow-lg transform hover:-translate-y-0.5" 
                                   style="border-color: #32A7E2; color: #32A7E2; background-color: rgba(50, 167, 226, 0.05);">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    {{ __('products.send_message') }}
                            </a>
                        @endif
                    @else
                            <a href="/client/login" class="flex items-center justify-center gap-2 w-full px-6 py-4 rounded-xl font-bold text-white transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5" style="background: linear-gradient(135deg, #32A7E2, #2B96D1);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                            {{ __('products.login_to_request') }}
                        </a>
                    @endauth
                </div>
                </div>

                <!-- Description Card -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6" style="color: #32A7E2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                        {{ __('products.description_title') }}
                    </h3>
                    <p class="text-gray-700 leading-relaxed text-base">{{ $product->description }}</p>
                </div>

                <!-- Technical Details Card -->
                @if($product->technical_details)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6" style="color: #32A7E2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            التفاصيل التقنية
                        </h3>
                        <p class="text-gray-700 leading-relaxed text-base">{{ $product->technical_details }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                        <svg class="w-8 h-8" style="color: #32A7E2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        منتجات مشابهة
                    </h2>
                    <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="text-sm font-bold hover:underline" style="color: #32A7E2;">
                        عرض الكل
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <a 
                            href="{{ route('products.show', $related->slug) }}" 
                            class="group bg-white rounded-2xl overflow-hidden border-2 border-gray-100 hover:border-[#32A7E2] hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1"
                        >
                            <div class="relative h-48 bg-gradient-to-br overflow-hidden" style="background: linear-gradient(135deg, rgba(50, 167, 226, 0.1), rgba(111, 194, 66, 0.05));">
                                @if($related->getFirstMediaUrl('images'))
                                    <img src="{{ $related->getFirstMediaUrl('images') }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-base mb-2 text-slate-900 line-clamp-2 group-hover:text-[#32A7E2] transition-colors min-h-[3rem]">
                                    {{ $related->name }}
                                </h3>
                                <p class="text-2xl font-bold" style="color: #32A7E2;">
                                    {{ number_format($related->price, 0) }} 
                                    <span class="text-sm text-gray-500 font-normal">DZD</span>
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    function changeMainImage(url) {
        document.getElementById('mainImage').src = url;
    }
</script>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .grid > a {
        animation: fadeIn 0.5s ease-out;
        animation-fill-mode: both;
    }
    
    .grid > a:nth-child(1) { animation-delay: 0.1s; }
    .grid > a:nth-child(2) { animation-delay: 0.2s; }
    .grid > a:nth-child(3) { animation-delay: 0.3s; }
    .grid > a:nth-child(4) { animation-delay: 0.4s; }
</style>
@endsection
