<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is in session
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        // Check if locale is in request
        elseif ($request->has('locale')) {
            $locale = $request->get('locale');
            Session::put('locale', $locale);
        }
        // Use default locale
        else {
            $locale = config('translatable.fallback_locale', 'ar');
        }

        // Validate locale
        $supportedLocales = array_keys(config('translatable.locales'));
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('translatable.fallback_locale', 'ar');
        }

        // Set application locale
        App::setLocale($locale);

        return $next($request);
    }
}

