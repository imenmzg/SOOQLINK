<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        // Validate locale
        $supportedLocales = array_keys(config('translatable.locales', ['ar' => 'العربية', 'en' => 'English', 'fr' => 'Français']));
        
        if (!in_array($locale, $supportedLocales)) {
            $locale = 'ar'; // Default to Arabic
        }

        // Store locale in session
        Session::put('locale', $locale);
        
        // Set application locale
        app()->setLocale($locale);

        // Redirect back to previous page
        return Redirect::back();
    }
}

