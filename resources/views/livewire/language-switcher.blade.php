@php
    use App\Helpers\LocaleHelper;
    $currentLocale = app()->getLocale();
    $locales = LocaleHelper::availableLocales();
@endphp

<div class="relative inline-block text-left" x-data="{ open: false }">
    <div>
        <button 
            @click="open = !open" 
            type="button" 
            class="inline-flex items-center justify-center w-full rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-blue transition-colors"
        >
            <svg class="w-5 h-5 {{ LocaleHelper::isRtl() ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
            </svg>
            <span>{{ $locales[$currentLocale] }}</span>
            <svg class="-{{ LocaleHelper::isRtl() ? 'mr' : 'ml' }}-1 {{ LocaleHelper::isRtl() ? 'mr' : 'ml' }}-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div 
        x-show="open" 
        @click.away="open = false"
        x-transition
        class="origin-top-{{ LocaleHelper::isRtl() ? 'left' : 'right' }} absolute {{ LocaleHelper::isRtl() ? 'left' : 'right' }}-0 mt-2 w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50" 
        style="display: none;"
    >
        <div class="py-1">
            @foreach($locales as $code => $name)
                <button 
                    wire:click="switchLanguage('{{ $code }}')" 
                    class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors {{ $currentLocale === $code ? 'bg-gray-50 font-semibold' : '' }}"
                >
                    @if($currentLocale === $code)
                        <svg class="w-4 h-4 {{ LocaleHelper::isRtl() ? 'ml-2' : 'mr-2' }} text-primary-blue" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                    <span class="flex-1">{{ $name }}</span>
                    <span class="text-xs text-gray-500 uppercase">{{ $code }}</span>
                </button>
            @endforeach
        </div>
    </div>
</div>

