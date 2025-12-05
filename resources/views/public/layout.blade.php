@php
    use App\Helpers\LocaleHelper;
@endphp
<!DOCTYPE html>
<html lang="{{ LocaleHelper::htmlLang() }}" dir="{{ LocaleHelper::htmlDir() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SOOQLINK')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" sizes="32x32">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    <meta name="msapplication-TileImage" content="{{ asset('favicon.png') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-blue': '#32A7E2',
                        'secondary-green': '#6FC242',
                        'dark-gray': '#2B2B2B',
                        'medium-gray': '#606C78',
                        'light-gray': '#E9ECEF',
                        'soft-blue': '#E8F6FD',
                        'soft-green': '#EAF8E5',
                        'accent-dark-blue': '#1B4B72',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;600;700;800&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    @stack('styles')
    @if(request()->routeIs('home'))
    <!-- Preload Hero Image for Better Performance -->
    <link rel="preload" as="image" href="{{ asset('poignee-de-main-d-hommes-d-affaires.jpg') }}" fetchpriority="high">
    @endif
    
    <!-- Alpine.js for Language Switcher -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    @include('public.partials.navbar')
    
    <main>
        @yield('content')
    </main>
    
    <footer class="bg-slate-900 text-white py-16 mt-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <img src="{{ asset('logo.png') }}" alt="SOOQLINK" class="h-10 w-auto mb-6 brightness-0 invert">
                    <p class="text-slate-400 text-sm leading-relaxed">{{ __('footer.description') }}</p>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-lg">{{ __('footer.product_title') }}</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">{{ __('footer.products') }}</a></li>
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ __('footer.homepage') }}</a></li>
                        <li><a href="/supplier/register" class="hover:text-white transition-colors">{{ __('footer.join_supplier') }}</a></li>
                        <li><a href="/client/register" class="hover:text-white transition-colors">{{ __('footer.join_client') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-lg">{{ __('footer.company_title') }}</h4>
                    <ul class="space-y-3 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('footer.about_us') }}</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('footer.how_it_works') }}</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('footer.faq') }}</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">{{ __('footer.contact') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-lg">{{ __('footer.follow_title') }}</h4>
                    <div class="flex gap-4 mb-6">
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all" style="background-color: rgb(30, 41, 59);" onmouseover="this.style.backgroundColor='#32A7E2'" onmouseout="this.style.backgroundColor='rgb(30, 41, 59)'">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all" style="background-color: rgb(30, 41, 59);" onmouseover="this.style.backgroundColor='#32A7E2'" onmouseout="this.style.backgroundColor='rgb(30, 41, 59)'">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all" style="background-color: rgb(30, 41, 59);" onmouseover="this.style.backgroundColor='#32A7E2'" onmouseout="this.style.backgroundColor='rgb(30, 41, 59)'">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                    <p class="text-sm text-slate-400">{{ __('footer.email') }}</p>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-slate-400">&copy; {{ date('Y') }} SOOQLINK. {{ __('footer.rights') }}</p>
                    <div class="flex gap-6 text-sm text-slate-400">
                        <a href="#" class="hover:text-white transition-colors">{{ __('footer.privacy') }}</a>
                        <a href="#" class="hover:text-white transition-colors">{{ __('footer.terms') }}</a>
                        <a href="#" class="hover:text-white transition-colors">{{ __('footer.cookies') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>

