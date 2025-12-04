<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher extends Component
{
    public function switchLanguage($locale)
    {
        $supportedLocales = array_keys(config('translatable.locales'));
        
        if (in_array($locale, $supportedLocales)) {
            Session::put('locale', $locale);
            app()->setLocale($locale);
            
            // Refresh the page to apply the new locale
            return redirect()->to(url()->current());
        }
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}

