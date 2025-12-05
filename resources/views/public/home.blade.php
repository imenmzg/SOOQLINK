@extends('public.layout')

@section('title', 'SOOQLINK - منصة ربط الشركات بالموردين')

@section('content')
<div class="min-h-screen bg-white">
    <!-- Hero Section with Business Handshake Image -->
    <div class="hero-section relative bg-gradient-to-br overflow-hidden" style="background: linear-gradient(to bottom right, rgba(50, 167, 226, 0.05), white, rgba(111, 194, 66, 0.05));">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl" style="background-color: rgba(50, 167, 226, 0.1);"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full blur-3xl" style="background-color: rgba(111, 194, 66, 0.1);"></div>
        
        <!-- Small UI Elements - Dots Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, #32A7E2 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28 lg:py-36">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Right Content - Text Section (RTL) -->
                <div class="space-y-7 max-w-2xl mx-auto lg:mx-0 lg:mr-auto">
                    <!-- Badge -->
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white shadow-md text-sm font-semibold transition-all hover:shadow-lg" style="color: #32A7E2; border: 1px solid rgba(50, 167, 226, 0.2);">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ __('home.hero_badge') }}</span>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <h1 class="text-5xl sm:text-6xl md:text-7xl font-bold text-slate-900 leading-tight">
                        {{ __('home.hero_title_1') }}
                        <span class="block mt-2" style="color: #32A7E2;">{{ __('home.hero_title_2') }}</span>
                    </h1>
                    
                    <!-- Subtitle -->
                    <p class="text-lg sm:text-xl text-slate-600 leading-relaxed">
                        {{ __('home.hero_subtitle') }}
                    </p>
                    
                    <!-- Stats - Compact Inline -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white shadow-sm border transition-all hover:shadow-md" style="border-color: rgba(50, 167, 226, 0.15);">
                            <span class="text-2xl font-bold" style="color: #32A7E2;">
                                @try
                                    {{ \App\Models\Supplier::verified()->count() }}+
                                @catch(\Exception $e)
                                    0+
                                @endtry
                            </span>
                            <span class="text-sm text-slate-600 font-medium">{{ __('home.hero_verified_suppliers') }}</span>
                        </div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white shadow-sm border transition-all hover:shadow-md" style="border-color: rgba(111, 194, 66, 0.15);">
                            <span class="text-2xl font-bold" style="color: #6FC242;">
                                @try
                                    {{ \App\Models\Product::published()->count() }}+
                                @catch(\Exception $e)
                                    0+
                                @endtry
                            </span>
                            <span class="text-sm text-slate-600 font-medium">{{ __('home.hero_available_products') }}</span>
                        </div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white shadow-sm border transition-all hover:shadow-md" style="border-color: rgba(50, 167, 226, 0.15);">
                            <span class="text-2xl font-bold" style="color: #32A7E2;">
                                @try
                                    {{ \App\Models\Category::active()->count() }}
                                @catch(\Exception $e)
                                    0
                                @endtry
                            </span>
                            <span class="text-sm text-slate-600 font-medium">{{ __('home.hero_main_categories') }}</span>
                        </div>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="{{ route('products.index') }}" class="group inline-flex items-center gap-2 px-8 py-4 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1" style="background: linear-gradient(135deg, #32A7E2, #2B96D1);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span>{{ __('home.hero_explore_products') }}</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        <a href="/supplier/register" class="inline-flex items-center gap-2 px-8 py-4 bg-white font-bold rounded-xl border-2 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-1" style="color: #32A7E2; border-color: rgba(50, 167, 226, 0.3);" onmouseover="this.style.borderColor='#32A7E2'; this.style.backgroundColor='rgba(50, 167, 226, 0.05)'" onmouseout="this.style.borderColor='rgba(50, 167, 226, 0.3)'; this.style.backgroundColor='white'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span>{{ __('home.hero_join_supplier') }}</span>
                        </a>
                    </div>
                </div>
                
                <!-- Right Content - Business Handshake Image -->
                <div class="hero-image relative hidden lg:flex lg:items-center lg:justify-center">
                    <div class="relative w-full max-w-2xl">
                        <!-- Decorative Background Elements -->
                        <div class="absolute -inset-8 rounded-3xl opacity-20 blur-3xl" style="background: linear-gradient(135deg, #32A7E2, #6FC242);"></div>
                        
                        <!-- Image Frame -->
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl transform transition-transform hover:scale-[1.02] duration-500">
                            <!-- Gradient Border -->
                            <div class="absolute -inset-0.5 rounded-3xl" style="background: linear-gradient(135deg, #32A7E2, #6FC242); opacity: 0.8;"></div>
                            
                            <!-- Image Container -->
                            <div class="relative rounded-3xl overflow-hidden bg-white p-3">
                                <div class="relative rounded-2xl overflow-hidden aspect-[4/3]">
                                    <!-- Loading Placeholder -->
                                    <div class="absolute inset-0 animate-pulse" style="background: linear-gradient(135deg, rgba(50, 167, 226, 0.1), rgba(111, 194, 66, 0.1));"></div>
                                    
                                    <!-- Main Image -->
                                    <img 
                                        src="{{ asset('poignee-de-main-d-hommes-d-affaires.jpg') }}" 
                                        alt="Two Business People Shaking Hands" 
                                        class="relative w-full h-full object-cover transition-opacity duration-700 rounded-2xl"
                                        loading="eager"
                                        fetchpriority="high"
                                        decoding="async"
                                        onload="this.style.opacity='1'; this.previousElementSibling.style.display='none';"
                                        style="opacity: 0;"
                                    >
                                </div>
                                    </div>
                                    </div>
                        
                        <!-- Floating Trust Badge - Top Right -->
                        <div class="floating-element absolute -top-6 -right-6 bg-white rounded-2xl shadow-2xl p-5 backdrop-blur-sm border border-gray-100 transform hover:scale-105 transition-transform z-10">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="absolute inset-0 rounded-xl blur-md opacity-50" style="background: linear-gradient(135deg, #32A7E2, #2B96D1);"></div>
                                    <div class="relative w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #32A7E2, #2B96D1);">
                                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-slate-900">{{ __('home.trust_badge') }}</div>
                                    <div class="text-xs text-slate-600 font-medium">{{ __('home.trust_description') }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Growth Badge - Bottom Left -->
                        <div class="floating-element absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-2xl p-5 backdrop-blur-sm border border-gray-100 transform hover:scale-105 transition-transform z-10">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <div class="absolute inset-0 rounded-xl blur-md opacity-50" style="background: linear-gradient(135deg, #6FC242, #5db336);"></div>
                                    <div class="relative w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #6FC242, #5db336);">
                                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-slate-900">{{ __('home.growth_badge') }}</div>
                                    <div class="text-xs text-slate-600 font-medium">{{ __('home.growth_description') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Section - Modern Card Layout -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="text-center mb-12 md:mb-16 animate-on-scroll fade-in-up">
            <div class="inline-block mb-4">
                <div class="h-1.5 w-24 rounded-full mx-auto shadow-lg" style="background: linear-gradient(to left, #32A7E2, #6FC242);"></div>
            </div>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-slate-900">{{ __('home.browse_title') }}</h2>
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto">{{ __('home.browse_subtitle') }}</p>
                </div>
                
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $categoryIcons = [
                    'مواد البناء' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
                    'الأجهزة الإلكترونية' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>',
                    'الأثاث' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
                    'الملابس والنسيج' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>',
                    'المواد الغذائية' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>',
                    'السيارات وقطع الغيار' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>',
                    'الأدوات المكتبية' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
                    'المنتجات الطبية' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
                    'المنتجات الزراعية' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>',
                    'أخرى' => '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>',
                ];
            @endphp
            @foreach($categories as $index => $category)
                @php
                    $icon = $categoryIcons[$category->name] ?? '<svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>';
                    $isBlue = $index % 2 == 0;
                    $bgColor = $isBlue ? '#32A7E2' : '#6FC242';
                    $darkColor = $isBlue ? '#1B4B72' : '#4A9D2F';
                    $staggerClass = 'stagger-' . (($index % 6) + 1);
                @endphp
                <a 
                    href="{{ route('products.index', ['category' => $category->id]) }}" 
                    class="animate-on-scroll {{ $staggerClass }} group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-slate-200 hover:border-transparent hover:scale-105"
                >
                    <!-- SOOQLINK Colored Background on Hover -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300" style="background: linear-gradient(135deg, {{ $bgColor }}, {{ $darkColor }});"></div>
                    
                    <!-- Content Layout -->
                    <div class="relative flex items-start gap-6">
                        <!-- Icon Container -->
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300" style="background: linear-gradient(135deg, {{ $bgColor }}, {{ $darkColor }});">
                                {!! $icon !!}
                    </div>
                </div>
                
                        <!-- Text Content -->
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-xl mb-2 text-slate-900 group-hover:text-white transition-colors duration-300">
                                {{ $category->name }}
                            </h3>
                            @if($category->description)
                                <p class="text-sm text-slate-600 group-hover:text-white/80 transition-colors duration-300 mb-3 line-clamp-2">
                                    {{ $category->description }}
                                </p>
                            @endif
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-2 text-sm text-slate-600 group-hover:text-white/90 transition-colors duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                                    <span class="font-semibold">{{ $category->products()->count() }} {{ __('home.products_count') }}</span>
            </div>
                    </div>
                </div>
                
                        <!-- Arrow Icon -->
                        <div class="flex-shrink-0 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 translate-x-2 transition-all duration-300">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </div>
                </div>
                
                    <!-- Bottom Accent Line -->
                    <div class="absolute bottom-0 left-0 right-0 h-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300" style="background: linear-gradient(to left, {{ $bgColor }}, {{ $darkColor }});"></div>
                    </a>
                @endforeach
            </div>
        </div>

    <!-- Image Showcase Section - Modern Layout -->
    <div class="relative bg-gradient-to-br from-slate-50 to-white overflow-hidden">
        <!-- Decorative Background -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full" style="background: radial-gradient(circle, #32A7E2, transparent); filter: blur(100px);"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full" style="background: radial-gradient(circle, #6FC242, transparent); filter: blur(100px);"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="text-center mb-12 md:mb-16 animate-on-scroll fade-in-up">
                <div class="inline-block mb-4">
                    <div class="h-1.5 w-24 rounded-full mx-auto shadow-lg" style="background: linear-gradient(to left, #32A7E2, #6FC242);"></div>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-slate-900">{{ __('home.explore_title') }}</h2>
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto">{{ __('home.explore_subtitle') }}</p>
            </div>
            
            <!-- Modern Image Layout -->
            <div class="space-y-8">
                <!-- Row 1: Full Width Large Image -->
                <div class="animate-on-scroll group relative rounded-2xl md:rounded-3xl overflow-hidden shadow-2xl h-[400px] md:h-[500px]">
                    <img 
                        src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=1400&h=800&fit=crop" 
                        alt="Business Team" 
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                    >
                    <div class="absolute inset-0" style="background: linear-gradient(to right, rgba(50, 167, 226, 0.85), rgba(50, 167, 226, 0.6), transparent);"></div>
                    <div class="absolute inset-0 flex items-center p-6 sm:p-8 md:p-12 text-white">
                        <div class="max-w-2xl">
                            <h3 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-4 md:mb-6">{{ __('home.support_24_7') }}</h3>
                            <p class="text-base sm:text-lg md:text-xl mb-6 md:mb-8 leading-relaxed" style="color: rgba(255, 255, 255, 0.9);">{{ __('home.support_desc') }}</p>
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/30">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-bold text-lg">{{ __('home.technical_support') }}</div>
                                    <div class="text-sm" style="color: rgba(255, 255, 255, 0.8);">{{ __('home.always_available') }}</div>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
                
                <!-- Row 2: Two Equal Large Images -->
                <div class="grid md:grid-cols-2 gap-4 md:gap-6">
                    <div class="animate-on-scroll slide-right stagger-1 group relative rounded-2xl md:rounded-3xl overflow-hidden shadow-2xl h-80 md:h-96">
                        <img 
                            src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1000&h=700&fit=crop" 
                            alt="Business Partnership" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        >
                        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(111, 194, 66, 0.85), rgba(111, 194, 66, 0.5), transparent);"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10 text-white">
                            <h3 class="text-xl sm:text-2xl md:text-3xl font-bold mb-2 md:mb-3">{{ __('home.strategic_partnerships') }}</h3>
                            <p class="text-sm sm:text-base md:text-lg leading-relaxed" style="color: rgba(255, 255, 255, 0.9);">{{ __('home.strategic_desc') }}</p>
                        </div>
                    </div>
                    
                    <div class="animate-on-scroll slide-left stagger-2 group relative rounded-2xl md:rounded-3xl overflow-hidden shadow-2xl h-80 md:h-96">
                        <img 
                            src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1000&h=700&fit=crop" 
                            alt="Business Analytics" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        >
                        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(50, 167, 226, 0.85), rgba(50, 167, 226, 0.5), transparent);"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10 text-white">
                            <h3 class="text-xl sm:text-2xl md:text-3xl font-bold mb-2 md:mb-3">{{ __('home.smart_analytics') }}</h3>
                            <p class="text-sm sm:text-base md:text-lg leading-relaxed" style="color: rgba(255, 255, 255, 0.9);">{{ __('home.analytics_desc') }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Row 3: Three Equal Images -->
                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                    <div class="animate-on-scroll scale stagger-1 group relative rounded-xl md:rounded-2xl overflow-hidden shadow-xl h-64 md:h-80">
                        <img 
                            src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=700&h=500&fit=crop" 
                            alt="Modern Office" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 text-white">
                            <h4 class="font-bold text-base sm:text-lg md:text-xl mb-1 md:mb-2">{{ __('home.modern_interface') }}</h4>
                            <p class="text-xs sm:text-sm md:text-base text-slate-200">{{ __('home.modern_desc') }}</p>
                        </div>
                    </div>
                    
                    <div class="animate-on-scroll scale stagger-2 group relative rounded-xl md:rounded-2xl overflow-hidden shadow-xl h-64 md:h-80">
                        <img 
                            src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=700&h=500&fit=crop" 
                            alt="Business Growth" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        >
                        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(111, 194, 66, 0.8), transparent);"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 text-white">
                            <h4 class="font-bold text-base sm:text-lg md:text-xl mb-1 md:mb-2">{{ __('home.continuous_growth') }}</h4>
                            <p class="text-xs sm:text-sm md:text-base" style="color: rgba(255, 255, 255, 0.9);">{{ __('home.growth_desc') }}</p>
                        </div>
                    </div>
                    
                    <div class="animate-on-scroll scale stagger-3 group relative rounded-xl md:rounded-2xl overflow-hidden shadow-xl h-64 md:h-80 sm:col-span-2 md:col-span-1">
                        <img 
                            src="https://images.unsplash.com/photo-1556761175-4b46a572b786?w=700&h=500&fit=crop" 
                            alt="Business Success" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                        >
                        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(50, 167, 226, 0.8), transparent);"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 md:p-8 text-white">
                            <h4 class="font-bold text-base sm:text-lg md:text-xl mb-1 md:mb-2">{{ __('home.guaranteed_success') }}</h4>
                            <p class="text-xs sm:text-sm md:text-base" style="color: rgba(255, 255, 255, 0.9);">{{ __('home.success_desc') }}</p>
                </div>
            </div>
        </div>
            </div>
            </div>
        </div>

    <!-- Featured Products Section with Premium Borders -->
    @if($featuredProducts->count() > 0)
    <div class="bg-slate-50 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="text-center mb-12 md:mb-16 animate-on-scroll fade-in-up">
                <div class="inline-block mb-4">
                    <div class="h-1.5 w-24 rounded-full mx-auto shadow-lg" style="background: linear-gradient(to right, #32A7E2, #32A7E2, #6FC242); box-shadow: 0 10px 15px -3px rgba(50, 167, 226, 0.3);"></div>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-slate-900">{{ __('home.featured_products_title') }}</h2>
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto">{{ __('home.featured_products_subtitle') }}</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $index => $product)
                    @php
                        $staggerClass = 'stagger-' . (($index % 4) + 1);
                    @endphp
                    <a 
                        href="{{ route('products.show', $product->slug) }}" 
                        class="animate-on-scroll {{ $staggerClass }} group relative bg-white rounded-xl overflow-hidden border-2 border-slate-200 hover:shadow-xl transition-all duration-500 hover:scale-105"
                        style="border-color: rgb(226, 232, 240);"
                        onmouseover="this.style.borderColor='#32A7E2'"
                        onmouseout="this.style.borderColor='rgb(226, 232, 240)'"
                    >
                        <!-- Top colored accent line -->
                        <div class="absolute top-0 left-0 right-0 h-1 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg rounded-t-xl" style="background: linear-gradient(to right, #32A7E2, #32A7E2, #6FC242); box-shadow: 0 10px 15px -3px rgba(50, 167, 226, 0.5);"></div>
                        
                        <!-- Glow effect on hover -->
                        <div class="absolute inset-0 transition-all rounded-xl" style="background: linear-gradient(to bottom right, rgba(50, 167, 226, 0), rgba(111, 194, 66, 0));" onmouseover="this.style.background='linear-gradient(to bottom right, rgba(50, 167, 226, 0.05), rgba(111, 194, 66, 0.05))'" onmouseout="this.style.background='linear-gradient(to bottom right, rgba(50, 167, 226, 0), rgba(111, 194, 66, 0))'"></div>
                        
                        <div class="relative h-48 bg-slate-100">
                            @if($product->getFirstMediaUrl('images'))
                                <img 
                                    src="{{ $product->getFirstMediaUrl('images') }}" 
                                    alt="{{ $product->name }}" 
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            @if($product->supplier && $product->supplier->isVerified())
                                <div class="absolute top-2 left-2 text-white px-2 py-1 rounded-lg text-xs font-semibold flex items-center gap-1 shadow-xl border-2 border-white" style="background-color: #6FC242; box-shadow: 0 20px 25px -5px rgba(111, 194, 66, 0.5);">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('home.verified') }}
                                </div>
                            @endif
                        </div>
                        <div class="p-4 relative">
                            <h3 class="font-bold text-base mb-2 text-slate-900 line-clamp-2 transition-colors" style="color: rgb(15, 23, 42);" onmouseover="this.style.color='#32A7E2'" onmouseout="this.style.color='rgb(15, 23, 42)'">{{ $product->name }}</h3>
                            <p class="text-sm text-slate-500 mb-3">{{ $product->supplier->company_name ?? 'N/A' }}</p>
                            <div class="flex items-center justify-between">
                                <p class="text-xl font-bold" style="color: #32A7E2;">{{ number_format($product->price, 0) }} <span class="text-sm text-slate-500 font-normal">DZD</span></p>
                                @if($product->supplier && $product->supplier->average_rating > 0)
                                    <div class="flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-lg border border-slate-200 shadow-sm">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-xs font-semibold text-slate-700">{{ number_format($product->supplier->average_rating, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" class="relative inline-flex items-center gap-2 px-8 py-4 text-white font-semibold rounded-xl transition-all shadow-lg hover:shadow-2xl overflow-hidden group border-2" style="background-color: #32A7E2; border-color: #32A7E2; box-shadow: 0 10px 15px -3px rgba(50, 167, 226, 0.25);" onmouseover="this.style.backgroundColor='#2a95d1'; this.style.borderColor='#2a95d1'" onmouseout="this.style.backgroundColor='#32A7E2'; this.style.borderColor='#32A7E2'">
                    <span class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background: linear-gradient(to right, #32A7E2, #32A7E2, #32A7E2);"></span>
                    <span class="relative flex items-center gap-2">
                        <span>{{ __('home.view_all_products') }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Features Section - Large Cards with Icons -->
    <div class="bg-gradient-to-b from-slate-50 via-white to-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="text-center mb-12 md:mb-16 animate-on-scroll fade-in-up">
                <div class="inline-block mb-4">
                    <div class="h-1.5 w-24 rounded-full mx-auto shadow-lg" style="background: linear-gradient(to left, #32A7E2, #6FC242);"></div>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-slate-900">{{ __('home.features_title') }}</h2>
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto">{{ __('home.features_subtitle') }}</p>
            </div>
            
            <!-- Grid 2x2 Layout -->
            <div class="grid md:grid-cols-2 gap-6 md:gap-8">
                <!-- Feature 1: Advanced Search -->
                <div class="animate-on-scroll stagger-1 group relative bg-white rounded-2xl md:rounded-3xl p-6 md:p-8 lg:p-10 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden border border-slate-100 hover:scale-[1.02]">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #32A7E2 1px, transparent 0); background-size: 40px 40px;"></div>
                    </div>
                    
                    <!-- Large Number Background -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full opacity-10 group-hover:opacity-20 transition-opacity duration-500" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);"></div>
                    
                    <!-- Icon Container -->
                    <div class="relative mb-4 md:mb-6">
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-white shadow-2xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-500" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);">
                            <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="relative">
                        <h3 class="font-bold text-xl md:text-2xl mb-3 md:mb-4 text-slate-900">{{ __('home.advanced_search_title') }}</h3>
                        <p class="text-slate-600 leading-relaxed mb-4 md:mb-6 text-sm md:text-base">
                            {{ __('home.advanced_search_desc') }}
                        </p>
                        
                        <!-- Feature List -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.advanced_filtering') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.instant_results') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.save_searches') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bottom Accent -->
                    <div class="absolute bottom-0 left-0 right-0 h-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background: linear-gradient(to left, #32A7E2, #1B4B72);"></div>
                </div>
                
                <!-- Feature 2: Dashboard -->
                <div class="animate-on-scroll stagger-2 group relative bg-white rounded-2xl md:rounded-3xl p-6 md:p-8 lg:p-10 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden border border-slate-100 hover:scale-[1.02]">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #6FC242 1px, transparent 0); background-size: 40px 40px;"></div>
                    </div>
                    
                    <!-- Large Number Background -->
                    <div class="absolute -top-10 -left-10 w-40 h-40 rounded-full opacity-10 group-hover:opacity-20 transition-opacity duration-500" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);"></div>
                    
                    <!-- Icon Container -->
                    <div class="relative mb-4 md:mb-6">
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-white shadow-2xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-500" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);">
                            <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="relative">
                        <h3 class="font-bold text-xl md:text-2xl mb-3 md:mb-4 text-slate-900">{{ __('home.dashboard_title') }}</h3>
                        <p class="text-slate-600 leading-relaxed mb-4 md:mb-6 text-sm md:text-base">
                            {{ __('home.dashboard_desc') }}
                        </p>
                        
                        <!-- Feature List -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.integrated_management') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.detailed_reports') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.fast_interface') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bottom Accent -->
                    <div class="absolute bottom-0 left-0 right-0 h-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background: linear-gradient(to left, #6FC242, #4A9D2F);"></div>
                </div>
                
                <!-- Feature 3: Security -->
                <div class="animate-on-scroll stagger-3 group relative bg-white rounded-2xl md:rounded-3xl p-6 md:p-8 lg:p-10 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden border border-slate-100 hover:scale-[1.02]">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #32A7E2 1px, transparent 0); background-size: 40px 40px;"></div>
                    </div>
                    
                    <!-- Large Number Background -->
                    <div class="absolute -top-10 -right-10 w-40 h-40 rounded-full opacity-10 group-hover:opacity-20 transition-opacity duration-500" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);"></div>
                    
                    <!-- Icon Container -->
                    <div class="relative mb-4 md:mb-6">
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-white shadow-2xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-500" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);">
                            <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="relative">
                        <h3 class="font-bold text-xl md:text-2xl mb-3 md:mb-4 text-slate-900">{{ __('home.security_title') }}</h3>
                        <p class="text-slate-600 leading-relaxed mb-4 md:mb-6 text-sm md:text-base">
                            {{ __('home.security_desc') }}
                        </p>
                        
                        <!-- Feature List -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.security_supplier_check') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.security_encryption') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.security_protection') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bottom Accent -->
                    <div class="absolute bottom-0 left-0 right-0 h-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background: linear-gradient(to left, #32A7E2, #1B4B72);"></div>
                </div>
                
                <!-- Feature 4: Communication -->
                <div class="animate-on-scroll stagger-4 group relative bg-white rounded-2xl md:rounded-3xl p-6 md:p-8 lg:p-10 shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden border border-slate-100 hover:scale-[1.02]">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-5">
                        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, #6FC242 1px, transparent 0); background-size: 40px 40px;"></div>
                    </div>
                    
                    <!-- Large Number Background -->
                    <div class="absolute -top-10 -left-10 w-40 h-40 rounded-full opacity-10 group-hover:opacity-20 transition-opacity duration-500" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);"></div>
                    
                    <!-- Icon Container -->
                    <div class="relative mb-4 md:mb-6">
                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-xl md:rounded-2xl flex items-center justify-center text-white shadow-2xl group-hover:scale-110 group-hover:rotate-6 transition-all duration-500" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);">
                            <svg class="w-8 h-8 md:w-10 md:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="relative">
                        <h3 class="font-bold text-xl md:text-2xl mb-3 md:mb-4 text-slate-900">{{ __('home.communication_title') }}</h3>
                        <p class="text-slate-600 leading-relaxed mb-4 md:mb-6 text-sm md:text-base">
                            {{ __('home.communication_desc') }}
                        </p>
                        
                        <!-- Feature List -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.communication_instant') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.communication_tracking') }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-700">
                                <div class="flex-shrink-0 w-6 h-6 rounded-lg flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm">{{ __('home.communication_files') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bottom Accent -->
                    <div class="absolute bottom-0 left-0 right-0 h-1.5 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="background: linear-gradient(to left, #6FC242, #4A9D2F);"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section - Accordion Style -->
    <div class="bg-white border-y border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="text-center mb-12 md:mb-16 animate-on-scroll fade-in-up">
                <div class="inline-block mb-4">
                    <div class="h-1.5 w-24 rounded-full mx-auto shadow-lg" style="background: linear-gradient(to left, #32A7E2, #6FC242);"></div>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-slate-900">{{ __('home.faq_title') }}</h2>
                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto">{{ __('home.faq_subtitle') }}</p>
            </div>
            
            <!-- FAQ Items -->
            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="animate-on-scroll stagger-1 group bg-white rounded-xl border-2 border-slate-200 transition-all duration-300 overflow-hidden shadow-sm hover:shadow-lg" style="border-color: rgb(226, 232, 240);" onmouseover="this.style.borderColor='rgba(50, 167, 226, 0.5)'" onmouseout="this.style.borderColor='rgb(226, 232, 240)'">
                    <button class="w-full px-6 py-5 text-right flex items-center justify-between gap-4 focus:outline-none" onclick="toggleFAQ(this)">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-slate-900 mb-1">{{ __('home.faq_q1') }}</h3>
                            <p class="text-slate-600 text-sm faq-answer hidden">{{ __('home.faq_a1') }}</p>
                        </div>
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-transform duration-300 faq-icon" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                </div>
                
                <!-- FAQ 2 -->
                <div class="animate-on-scroll stagger-2 group bg-white rounded-xl border-2 border-slate-200 transition-all duration-300 overflow-hidden shadow-sm hover:shadow-lg" style="border-color: rgb(226, 232, 240);" onmouseover="this.style.borderColor='rgba(111, 194, 66, 0.5)'" onmouseout="this.style.borderColor='rgb(226, 232, 240)'">
                    <button class="w-full px-6 py-5 text-right flex items-center justify-between gap-4 focus:outline-none" onclick="toggleFAQ(this)">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-slate-900 mb-1">{{ __('home.faq_q2') }}</h3>
                            <p class="text-slate-600 text-sm faq-answer hidden">{{ __('home.faq_a2') }}</p>
                        </div>
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-transform duration-300 faq-icon" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                </div>
                
                <!-- FAQ 3 -->
                <div class="animate-on-scroll stagger-3 group bg-white rounded-xl border-2 border-slate-200 transition-all duration-300 overflow-hidden shadow-sm hover:shadow-lg" style="border-color: rgb(226, 232, 240);" onmouseover="this.style.borderColor='rgba(50, 167, 226, 0.5)'" onmouseout="this.style.borderColor='rgb(226, 232, 240)'">
                    <button class="w-full px-6 py-5 text-right flex items-center justify-between gap-4 focus:outline-none" onclick="toggleFAQ(this)">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-slate-900 mb-1">{{ __('home.faq_q3') }}</h3>
                            <p class="text-slate-600 text-sm faq-answer hidden">{{ __('home.faq_a3') }}</p>
                        </div>
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-transform duration-300 faq-icon" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                </div>
                
                <!-- FAQ 4 -->
                <div class="animate-on-scroll stagger-4 group bg-white rounded-xl border-2 border-slate-200 transition-all duration-300 overflow-hidden shadow-sm hover:shadow-lg" style="border-color: rgb(226, 232, 240);" onmouseover="this.style.borderColor='rgba(111, 194, 66, 0.5)'" onmouseout="this.style.borderColor='rgb(226, 232, 240)'">
                    <button class="w-full px-6 py-5 text-right flex items-center justify-between gap-4 focus:outline-none" onclick="toggleFAQ(this)">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-slate-900 mb-1">{{ __('home.faq_q4') }}</h3>
                            <p class="text-slate-600 text-sm faq-answer hidden">{{ __('home.faq_a4') }}</p>
                        </div>
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-transform duration-300 faq-icon" style="background: linear-gradient(135deg, #6FC242, #4A9D2F);">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                </div>
                
                <!-- FAQ 5 -->
                <div class="animate-on-scroll stagger-5 group bg-white rounded-xl border-2 border-slate-200 transition-all duration-300 overflow-hidden shadow-sm hover:shadow-lg" style="border-color: rgb(226, 232, 240);" onmouseover="this.style.borderColor='rgba(50, 167, 226, 0.5)'" onmouseout="this.style.borderColor='rgb(226, 232, 240)'">
                    <button class="w-full px-6 py-5 text-right flex items-center justify-between gap-4 focus:outline-none" onclick="toggleFAQ(this)">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-slate-900 mb-1">{{ __('home.faq_q5') }}</h3>
                            <p class="text-slate-600 text-sm faq-answer hidden">{{ __('home.faq_a5') }}</p>
                        </div>
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center transition-transform duration-300 faq-icon" style="background: linear-gradient(135deg, #32A7E2, #1B4B72);">
                            <svg class="w-5 h-5 text-white transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Scroll Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(50, 167, 226, 0.3);
            }
            50% {
                box-shadow: 0 0 40px rgba(50, 167, 226, 0.6);
            }
        }

        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Simple and smooth scroll animations */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .animate-on-scroll.animated {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        /* Different animation directions */
        .animate-on-scroll.slide-right {
            transform: translateX(-50px);
        }

        .animate-on-scroll.slide-left {
            transform: translateX(50px);
        }

        .animate-on-scroll.scale {
            transform: scale(0.8);
        }

        .animate-on-scroll.slide-right.animated,
        .animate-on-scroll.slide-left.animated {
            transform: translateX(0) !important;
        }

        .animate-on-scroll.scale.animated {
            transform: scale(1) !important;
        }

        /* Floating animation for floating elements */
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Stagger delay for grid items */
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .stagger-5 { animation-delay: 0.5s; }
        .stagger-6 { animation-delay: 0.6s; }

        /* Smooth transitions */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Image loading optimization */
        .hero-image img {
            will-change: opacity;
            backface-visibility: hidden;
            transform: translateZ(0);
        }
    </style>

    <script>
        function toggleFAQ(button) {
            const answer = button.querySelector('.faq-answer');
            const icon = button.querySelector('.faq-icon svg');
            const isHidden = answer.classList.contains('hidden');
            
            // Close all other FAQs
            document.querySelectorAll('.faq-answer').forEach(item => {
                if (item !== answer) {
                    item.classList.add('hidden');
                }
            });
            document.querySelectorAll('.faq-icon svg').forEach(item => {
                if (item !== icon) {
                    item.classList.remove('rotate-180');
                }
            });
            
            // Toggle current FAQ
            if (isHidden) {
                answer.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                answer.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        // Simple and effective scroll animation
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -80px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animated');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all elements with animate-on-scroll class
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });

            // Add entrance animations to hero elements
            const heroTitle = document.querySelector('.hero-title');
            const heroSubtitle = document.querySelector('.hero-subtitle');
            const heroButtons = document.querySelector('.hero-buttons');
            const heroStats = document.querySelector('.hero-stats');
            const heroImage = document.querySelector('.hero-image');

            if (heroTitle) {
                setTimeout(() => heroTitle.classList.add('animated'), 200);
            }
            if (heroSubtitle) {
                setTimeout(() => heroSubtitle.classList.add('animated'), 400);
            }
            if (heroButtons) {
                setTimeout(() => heroButtons.classList.add('animated'), 600);
            }
            if (heroStats) {
                setTimeout(() => heroStats.classList.add('animated'), 800);
            }
            if (heroImage) {
                setTimeout(() => heroImage.classList.add('animated'), 500);
            }

            // Add floating animation to floating elements
            const floatingElements = document.querySelectorAll('.floating-element');
            floatingElements.forEach((el, index) => {
                el.classList.add('float-animation');
                el.style.animationDelay = `${index * 0.5}s`;
            });
        });
    </script>

    <!-- CTA Section - Premium Design -->
    <div class="relative text-white overflow-hidden" style="background: linear-gradient(to bottom right, #32A7E2, #2a95d1, #6FC242);">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full blur-3xl animate-pulse" style="background-color: rgba(111, 194, 66, 0.2); animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full blur-3xl animate-pulse" style="background-color: rgba(50, 167, 226, 0.1); animation-delay: 0.5s;"></div>
        </div>
        
        <!-- Pattern Overlay -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 50px 50px;"></div>
        </div>
        
        <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 md:pt-24 pb-16">
            <div class="text-center animate-on-scroll">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 md:px-6 py-2 md:py-3 rounded-full bg-white/10 backdrop-blur-md text-white text-xs md:text-sm font-semibold mb-4 md:mb-6 border border-white/20 shadow-lg">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ __('home.start_free_today') }}</span>
                </div>
                
                <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold mb-4 md:mb-6 leading-tight">
                    {{ __('home.ready_title') }}
                </h2>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-8 md:mb-12 max-w-3xl mx-auto leading-relaxed px-4" style="color: rgba(255, 255, 255, 0.9);">
                    {{ __('home.ready_subtitle') }}
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-wrap justify-center gap-4 md:gap-6 mb-8 md:mb-12 px-4">
                    <a href="/supplier/register" class="group relative inline-flex items-center gap-2 md:gap-3 px-6 md:px-8 lg:px-10 py-3 md:py-4 lg:py-5 bg-white font-bold text-base md:text-lg rounded-xl md:rounded-2xl transition-all shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 overflow-hidden border-2 border-white/20 w-full sm:w-auto" style="color: #32A7E2;" onmouseover="this.style.backgroundColor='rgba(50, 167, 226, 0.05)'" onmouseout="this.style.backgroundColor='white'">
                        <span class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700" style="background: linear-gradient(to right, rgba(50, 167, 226, 0), rgba(50, 167, 226, 0.1), rgba(50, 167, 226, 0));"></span>
                        <span class="relative z-10 flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span>{{ __('home.hero_join_supplier') }}</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
                    </a>
                    <a href="/client/register" class="group relative inline-flex items-center gap-2 md:gap-3 px-6 md:px-8 lg:px-10 py-3 md:py-4 lg:py-5 backdrop-blur-sm text-white font-bold text-base md:text-lg rounded-xl md:rounded-2xl transition-all shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 border-2 border-white/20 overflow-hidden w-full sm:w-auto" style="background-color: rgba(50, 167, 226, 0.9);" onmouseover="this.style.backgroundColor='rgba(50, 167, 226, 1)'" onmouseout="this.style.backgroundColor='rgba(50, 167, 226, 0.9)'">
                        <span class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700" style="background: linear-gradient(to right, rgba(50, 167, 226, 0), rgba(50, 167, 226, 0.5), rgba(50, 167, 226, 0));"></span>
                        <span class="relative z-10 flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>{{ __('navbar.register') }}</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="flex flex-wrap items-center justify-center gap-4 md:gap-6 lg:gap-8 px-4" style="color: rgba(255, 255, 255, 0.9);">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="color: rgba(111, 194, 66, 0.8);">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">{{ __('home.free_registration') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="color: rgba(111, 194, 66, 0.8);">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">{{ __('home.no_hidden_fees') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="color: rgba(111, 194, 66, 0.8);">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium">{{ __('home.continuous_support') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
