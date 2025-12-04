<nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm backdrop-blur-sm bg-white/95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center transition-transform hover:scale-105">
                    <img src="{{ asset('logo.png') }}" alt="SOOQLINK" class="h-10 w-auto">
                </a>
            </div>
            
            <!-- Menu Items -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="group relative text-base font-medium text-slate-700 hover:text-primary-blue transition-all duration-300 px-2 py-1 rounded-lg">
                    <span class="relative z-10">{{ __('navbar.home') }}</span>
                    <span class="absolute bottom-0 {{ app()->isLocale('ar') ? 'right' : 'left' }}-0 {{ app()->isLocale('ar') ? 'left' : 'right' }}-0 h-0.5 bg-primary-blue transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></span>
                    <span class="absolute inset-0 rounded-lg bg-primary-blue opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                </a>
                <a href="{{ route('suppliers.index') }}" class="group relative text-base font-medium text-slate-700 hover:text-primary-blue transition-all duration-300 px-2 py-1 rounded-lg">
                    <span class="relative z-10">{{ __('navbar.suppliers') }}</span>
                    <span class="absolute bottom-0 {{ app()->isLocale('ar') ? 'right' : 'left' }}-0 {{ app()->isLocale('ar') ? 'left' : 'right' }}-0 h-0.5 bg-primary-blue transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></span>
                    <span class="absolute inset-0 rounded-lg bg-primary-blue opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                </a>
                <a href="{{ route('products.index') }}" class="group relative text-base font-medium text-slate-700 hover:text-primary-blue transition-all duration-300 px-2 py-1 rounded-lg">
                    <span class="relative z-10">{{ __('navbar.products') }}</span>
                    <span class="absolute bottom-0 {{ app()->isLocale('ar') ? 'right' : 'left' }}-0 {{ app()->isLocale('ar') ? 'left' : 'right' }}-0 h-0.5 bg-primary-blue transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 rounded-full"></span>
                    <span class="absolute inset-0 rounded-lg bg-primary-blue opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                </a>
            </div>
            
            <!-- Buttons & Language Switcher -->
            <div class="flex items-center gap-3">
                <!-- Language Switcher -->
                <x-language-switcher />
                
                @auth
                    @if(auth()->user()->isSupplier())
                        <a href="/supplier" class="px-5 py-2.5 rounded-lg font-semibold text-white transition-all shadow-sm hover:shadow-md text-sm" style="background: linear-gradient(to right, #32A7E2, #2a95d1);" onmouseover="this.style.background='linear-gradient(to right, #2a95d1, #2384c0)'" onmouseout="this.style.background='linear-gradient(to right, #32A7E2, #2a95d1)'">
                            {{ __('navbar.dashboard') }}
                        </a>
                    @elseif(auth()->user()->isClient())
                        <a href="/client" class="px-5 py-2.5 rounded-lg font-semibold text-white transition-all shadow-sm hover:shadow-md text-sm" style="background: linear-gradient(to right, #32A7E2, #2a95d1);" onmouseover="this.style.background='linear-gradient(to right, #2a95d1, #2384c0)'" onmouseout="this.style.background='linear-gradient(to right, #32A7E2, #2a95d1)'">
                            {{ __('navbar.dashboard') }}
                        </a>
                    @elseif(auth()->user()->isAdmin())
                        <a href="/admin" class="px-5 py-2.5 rounded-lg font-semibold text-white transition-all shadow-sm hover:shadow-md text-sm" style="background: linear-gradient(to right, #32A7E2, #2a95d1);" onmouseover="this.style.background='linear-gradient(to right, #2a95d1, #2384c0)'" onmouseout="this.style.background='linear-gradient(to right, #32A7E2, #2a95d1)'">
                            {{ __('navbar.dashboard') }}
                        </a>
                    @endif
                @else
                    <a href="/supplier/login" class="px-5 py-2.5 rounded-lg font-medium text-primary-blue border border-primary-blue/30 hover:bg-primary-blue/10 transition-all text-sm">
                        {{ __('navbar.login') }}
                    </a>
                    <a href="/supplier/register" class="px-5 py-2.5 rounded-lg font-semibold text-white transition-all shadow-sm hover:shadow-md text-sm" style="background: linear-gradient(to right, #6FC242, #5fb038);" onmouseover="this.style.background='linear-gradient(to right, #5fb038, #4f9d2f)'" onmouseout="this.style.background='linear-gradient(to right, #6FC242, #5fb038)'">
                        {{ __('navbar.register') }}
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
