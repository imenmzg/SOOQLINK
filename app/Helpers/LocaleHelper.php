<?php

namespace App\Helpers;

class LocaleHelper
{
    /**
     * Check if the current locale is RTL
     */
    public static function isRtl(?string $locale = null): bool
    {
        $locale = $locale ?? app()->getLocale();
        return in_array($locale, ['ar']);
    }

    /**
     * Get text direction for the current locale
     */
    public static function direction(?string $locale = null): string
    {
        return self::isRtl($locale) ? 'rtl' : 'ltr';
    }

    /**
     * Get HTML lang attribute
     */
    public static function htmlLang(): string
    {
        return app()->getLocale();
    }

    /**
     * Get HTML dir attribute
     */
    public static function htmlDir(): string
    {
        return self::direction();
    }

    /**
     * Get available locales
     */
    public static function availableLocales(): array
    {
        return config('translatable.locales', [
            'ar' => 'العربية',
            'en' => 'English',
            'fr' => 'Français',
        ]);
    }

    /**
     * Get current locale name
     */
    public static function currentLocaleName(): string
    {
        $locales = self::availableLocales();
        return $locales[app()->getLocale()] ?? 'العربية';
    }
}

