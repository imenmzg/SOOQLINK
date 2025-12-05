@extends('public.layout')

@section('title', 'الموردين - SOOQLINK')

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
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('suppliers.page_badge') }}
                </div>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-slate-900 mb-4">
                    {{ __('suppliers.page_title') }}
                </h1>
                <p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto">
                    {{ __('suppliers.page_subtitle') }}
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Search and Stats Bar -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Search -->
                <div class="flex-1 w-full md:max-w-md">
                    <form method="GET" action="{{ route('suppliers.index') }}" class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="{{ __('suppliers.filter_search_placeholder') }}" 
                            class="w-full border-2 border-gray-200 rounded-xl px-5 py-3 pr-12 focus:outline-none transition-all text-sm"
                            style="border-color: rgb(226, 232, 240);"
                            onfocus="this.style.borderColor='#32A7E2'; this.style.boxShadow='0 0 0 3px rgba(50, 167, 226, 0.1)';"
                            onblur="this.style.borderColor='rgb(226, 232, 240)'; this.style.boxShadow='none';"
                        >
                        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#32A7E2] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>
                
                <!-- Stats -->
                <div class="flex items-center gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold" style="color: #32A7E2;">{{ $suppliers->total() }}</div>
                        <div class="text-xs text-gray-600">{{ __('suppliers.verified_supplier') }}</div>
                    </div>
                    <div class="h-12 w-px bg-gray-200"></div>
                    <div class="text-center">
                        <div class="text-2xl font-bold" style="color: #6FC242;">{{ $productsCount ?? 0 }}</div>
                        <div class="text-xs text-gray-600">{{ __('products.available') }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if($suppliers->count() > 0)
            <!-- Suppliers Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($suppliers as $supplier)
                    <div 
                        class="group bg-white rounded-2xl border-2 border-gray-100 hover:border-[#32A7E2] hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1"
                        style="box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);"
                    >
                        <a href="{{ route('supplier.show', $supplier->id) }}" class="block">
                            <!-- Supplier Header with Gradient -->
                            <div class="relative h-32 bg-gradient-to-br overflow-hidden" style="background: linear-gradient(135deg, rgba(50, 167, 226, 0.1) 0%, rgba(111, 194, 66, 0.05) 100%);">
                                <div class="absolute inset-0 opacity-10">
                                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #32A7E2 1px, transparent 0); background-size: 20px 20px;"></div>
                                </div>
                                <div class="relative h-full flex items-center justify-center">
                                    @if($supplier->getFirstMediaUrl('logo'))
                                        <img src="{{ $supplier->getFirstMediaUrl('logo') }}" alt="{{ $supplier->company_name }}" class="h-16 w-16 rounded-full object-cover border-4 border-white shadow-lg">
                                    @else
                                        <div class="h-16 w-16 rounded-full flex items-center justify-center text-2xl font-bold text-white shadow-lg" style="background: linear-gradient(135deg, #32A7E2, #2B96D1);">
                                            {{ substr($supplier->company_name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Verified Badge -->
                                @if($supplier->isVerified())
                                    <div class="absolute top-3 right-3 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold text-white shadow-lg" style="background: linear-gradient(135deg, #6FC242, #5db336);">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('suppliers.verified') }}
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <!-- Company Name -->
                                <h3 class="text-xl font-bold mb-3 text-slate-900 group-hover:text-[#32A7E2] transition-colors line-clamp-1">
                                    {{ $supplier->company_name }}
                                </h3>

                                <!-- Supplier Info -->
                                <div class="space-y-3 mb-4">
                                    @if($supplier->wilaya)
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: rgba(50, 167, 226, 0.1);">
                                                <svg class="w-4 h-4" style="color: #32A7E2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium">{{ $supplier->wilaya }}</span>
                                        </div>
                                    @endif

                                    @if($supplier->average_rating > 0)
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: rgba(251, 191, 36, 0.1);">
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <span class="text-sm font-bold text-slate-900">{{ number_format($supplier->average_rating, 1) }}</span>
                                                <span class="text-xs text-gray-500">({{ $supplier->total_reviews ?? 0 }} {{ trans_choice('suppliers.reviews_count', $supplier->total_reviews ?? 0) }})</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($supplier->products->count() > 0)
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: rgba(111, 194, 66, 0.1);">
                                                <svg class="w-4 h-4" style="color: #6FC242;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium">{{ $supplier->products->count() }} {{ trans_choice('suppliers.products_available', $supplier->products->count()) }}</span>
                                        </div>
                                    @endif
                                </div>

                                @if($supplier->company_description)
                                    <p class="text-gray-600 text-sm line-clamp-2 mb-5 leading-relaxed">
                                        {{ Str::limit($supplier->company_description, 100) }}
                                    </p>
                                @endif

                                <!-- View Button -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <span class="text-sm font-bold transition-colors" style="color: #32A7E2;">
                                        {{ __('suppliers.view_details') }}
                                    </span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" style="color: #32A7E2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-2">
                    {{ $suppliers->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-16 text-center">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, rgba(50, 167, 226, 0.1), rgba(111, 194, 66, 0.1));">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">{{ __('suppliers.no_suppliers_title') }}</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">{{ __('suppliers.no_suppliers_message') }}</p>
                <a href="{{ route('suppliers.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5" style="background-color: #32A7E2;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ __('suppliers.refresh_page') }}
                </a>
            </div>
        @endif
    </div>
</div>

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
    
    .grid > div {
        animation: fadeInUp 0.5s ease-out;
        animation-fill-mode: both;
    }
    
    .grid > div:nth-child(1) { animation-delay: 0.1s; }
    .grid > div:nth-child(2) { animation-delay: 0.2s; }
    .grid > div:nth-child(3) { animation-delay: 0.3s; }
    .grid > div:nth-child(4) { animation-delay: 0.4s; }
    .grid > div:nth-child(5) { animation-delay: 0.5s; }
    .grid > div:nth-child(6) { animation-delay: 0.6s; }
</style>
@endsection
