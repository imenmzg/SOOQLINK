# 🌍 SOOQLINK Multilingual Implementation Guide

## Complete Laravel + Filament Multilingual System
**Supporting: Arabic (RTL) | English (LTR) | French (LTR)**

---

## 📋 Table of Contents
1. [Overview](#overview)
2. [Installation Steps](#installation-steps)
3. [Backend Implementation](#backend-implementation)
4. [Filament Resources](#filament-resources)
5. [Frontend Implementation](#frontend-implementation)
6. [Language Switcher](#language-switcher)
7. [Translation Files](#translation-files)
8. [RTL/LTR Handling](#rtlltr-handling)
9. [Testing Guide](#testing-guide)
10. [Best Practices](#best-practices)

---

## 🎯 Overview

This implementation provides a complete multilingual system for SOOQLINK with:
- ✅ **3 Languages**: Arabic (RTL), English (LTR), French (LTR)
- ✅ **Translatable Models**: Categories, Products
- ✅ **Filament Integration**: Admin panel with language tabs
- ✅ **Dynamic RTL/LTR**: Automatic layout switching
- ✅ **Language Switcher**: Public and admin panels
- ✅ **Translation Files**: UI elements in all languages

---

## 🚀 Installation Steps

### Step 1: Install Packages
```bash
composer require spatie/laravel-translatable filament/spatie-laravel-translatable-plugin
composer dump-autoload
```

### Step 2: Run Migrations
```bash
php artisan migrate
```

**Note**: If in production, use:
```bash
php artisan migrate --force
```

### Step 3: Clear Cache
```bash
php artisan optimize:clear
```

---

## 🔧 Backend Implementation

### 1. Configuration (`config/translatable.php`)

```php
<?php

return [
    'locales' => [
        'ar' => 'العربية',
        'en' => 'English',
        'fr' => 'Français',
    ],
    'fallback_locale' => 'ar',
    'use_fallback' => true,
    'use_property_fallback' => true,
    'fallback_any' => true,
];
```

### 2. Middleware (`app/Http/Middleware/SetLocale.php`)

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } elseif ($request->has('locale')) {
            $locale = $request->get('locale');
            Session::put('locale', $locale);
        } else {
            $locale = config('translatable.fallback_locale', 'ar');
        }

        $supportedLocales = array_keys(config('translatable.locales'));
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('translatable.fallback_locale', 'ar');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
```

### 3. Register Middleware (`bootstrap/app.php`)

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->web(append: [
        \App\Http\Middleware\SetLocale::class,
    ]);
})
```

### 4. Translatable Models

#### Category Model
```php
<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'sort_order', 'is_active',
    ];
}
```

#### Product Model
```php
<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations;

    public $translatable = ['name', 'description', 'technical_details'];

    protected $fillable = [
        'supplier_id', 'category_id', 'name', 'slug', 'description',
        'technical_details', 'price', 'quantity', 'wilaya', 'location',
        'is_published', 'views_count',
    ];
}
```

---

## 📊 Filament Resources

### 1. Category Resource with Translations

```php
<?php

namespace App\Filament\Resources\Admin;

use Filament\Resources\Concerns\Translatable;

class CategoryResource extends Resource
{
    use Translatable;

    protected static ?string $model = Category::class;

    public static function getTranslatableLocales(): array
    {
        return ['ar', 'en', 'fr'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set, $livewire) {
                        if ($livewire->activeLocale === 'ar') {
                            $set('slug', \Illuminate\Support\Str::slug($state));
                        }
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Generated from Arabic name'),
                Forms\Components\Textarea::make('description')
                    ->rows(3),
                Forms\Components\TextInput::make('icon')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
```

### 2. Product Resource with Translations

```php
<?php

namespace App\Filament\Resources\Admin;

use Filament\Resources\Concerns\Translatable;

class ProductResource extends Resource
{
    use Translatable;

    protected static ?string $model = Product::class;

    public static function getTranslatableLocales(): array
    {
        return ['ar', 'en', 'fr'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Information')
                    ->schema([
                        Forms\Components\Select::make('supplier_id')
                            ->relationship('supplier', 'company_name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->rows(3),
                        Forms\Components\Textarea::make('technical_details')
                            ->rows(3)
                            ->label('Technical Details'),
                        // ... other fields
                    ]),
            ]);
    }
}
```

### 3. Filament Panel Configuration

Add to your Filament panel provider:

```php
use Filament\SpatieLaravelTranslatablePlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            SpatieLaravelTranslatablePlugin::make()
                ->defaultLocales(['ar', 'en', 'fr']),
        ]);
}
```

---

## 🎨 Frontend Implementation

### 1. LocaleHelper (`app/Helpers/LocaleHelper.php`)

```php
<?php

namespace App\Helpers;

class LocaleHelper
{
    public static function isRtl(?string $locale = null): bool
    {
        $locale = $locale ?? app()->getLocale();
        return in_array($locale, ['ar']);
    }

    public static function direction(?string $locale = null): string
    {
        return self::isRtl($locale) ? 'rtl' : 'ltr';
    }

    public static function htmlLang(): string
    {
        return app()->getLocale();
    }

    public static function htmlDir(): string
    {
        return self::direction();
    }

    public static function availableLocales(): array
    {
        return config('translatable.locales', [
            'ar' => 'العربية',
            'en' => 'English',
            'fr' => 'Français',
        ]);
    }

    public static function currentLocaleName(): string
    {
        $locales = self::availableLocales();
        return $locales[app()->getLocale()] ?? 'العربية';
    }
}
```

### 2. Update Layout (`resources/views/public/layout.blade.php`)

```blade
@php
    use App\Helpers\LocaleHelper;
@endphp
<!DOCTYPE html>
<html lang="{{ LocaleHelper::htmlLang() }}" dir="{{ LocaleHelper::htmlDir() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SOOQLINK')</title>
    <!-- ... rest of head -->
</head>
<body>
    <!-- ... content -->
</body>
</html>
```

---

## 🔄 Language Switcher

### 1. Blade Component (`resources/views/components/language-switcher.blade.php`)

```blade
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
            class="inline-flex items-center justify-center w-full rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
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
                <a 
                    href="{{ url()->current() }}?locale={{ $code }}" 
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentLocale === $code ? 'bg-gray-50 font-semibold' : '' }}"
                >
                    @if($currentLocale === $code)
                        <svg class="w-4 h-4 {{ LocaleHelper::isRtl() ? 'ml-2' : 'mr-2' }} text-primary-blue" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                    <span class="flex-1">{{ $name }}</span>
                    <span class="text-xs text-gray-500 uppercase">{{ $code }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
@endpush
```

### 2. Usage in Navbar

```blade
<!-- Add to navbar -->
<div class="flex items-center gap-3">
    <x-language-switcher />
    <!-- ... other buttons -->
</div>
```

---

## 📝 Translation Files

### Structure
```
lang/
├── ar/
│   ├── navbar.php
│   └── common.php
├── en/
│   ├── navbar.php
│   └── common.php
└── fr/
    ├── navbar.php
    └── common.php
```

### Example: `lang/ar/navbar.php`
```php
<?php

return [
    'home' => 'الرئيسية',
    'suppliers' => 'الموردين',
    'products' => 'المنتجات',
    'dashboard' => 'لوحة التحكم',
    'login' => 'الدخول',
    'register' => 'تسجيل',
];
```

### Example: `lang/en/navbar.php`
```php
<?php

return [
    'home' => 'Home',
    'suppliers' => 'Suppliers',
    'products' => 'Products',
    'dashboard' => 'Dashboard',
    'login' => 'Login',
    'register' => 'Register',
];
```

### Usage in Blade
```blade
<a href="{{ route('home') }}">{{ __('navbar.home') }}</a>
<a href="{{ route('suppliers.index') }}">{{ __('navbar.suppliers') }}</a>
<a href="{{ route('products.index') }}">{{ __('navbar.products') }}</a>
```

---

## 🔄 RTL/LTR Handling

### 1. Dynamic Direction in Blade

```blade
<!-- Conditional classes -->
<div class="{{ LocaleHelper::isRtl() ? 'text-right' : 'text-left' }}">
    Content
</div>

<!-- Conditional margins/padding -->
<svg class="w-5 h-5 {{ LocaleHelper::isRtl() ? 'ml-2' : 'mr-2' }}">
    <!-- icon -->
</svg>

<!-- Conditional positioning -->
<div class="absolute {{ LocaleHelper::isRtl() ? 'right' : 'left' }}-0">
    Content
</div>
```

### 2. Tailwind RTL Support

Add to your Tailwind config:

```javascript
tailwind.config = {
    theme: {
        extend: {
            // ... your config
        }
    }
}
```

### 3. CSS RTL Support

```css
/* Automatic RTL support */
[dir="rtl"] .ml-2 { margin-right: 0.5rem; margin-left: 0; }
[dir="rtl"] .mr-2 { margin-left: 0.5rem; margin-right: 0; }
[dir="rtl"] .text-left { text-align: right; }
[dir="rtl"] .text-right { text-align: left; }
```

---

## 🧪 Testing Guide

### 1. Test Migrations
```bash
php artisan migrate:fresh --seed
```

### 2. Test Language Switching
1. Visit homepage: `http://localhost:8000`
2. Click language switcher
3. Select "English" or "Français"
4. Verify:
   - URL has `?locale=en` or `?locale=fr`
   - Layout flips to LTR
   - Text changes to selected language

### 3. Test Filament Admin
1. Login to admin: `http://localhost:8000/admin`
2. Go to Categories or Products
3. Create/Edit a record
4. Verify:
   - Language tabs appear (AR | EN | FR)
   - Can enter different translations
   - Saves correctly

### 4. Test Frontend Display
1. Create a category with translations:
   - AR: "إلكترونيات"
   - EN: "Electronics"
   - FR: "Électronique"
2. Switch languages on frontend
3. Verify correct translation displays

### 5. Test RTL/LTR
1. Switch to Arabic → verify RTL layout
2. Switch to English → verify LTR layout
3. Check:
   - Text alignment
   - Menu positioning
   - Button placement
   - Icon positioning

---

## ✅ Best Practices

### 1. Always Provide Fallbacks
```php
// In models
public $translatable = ['name', 'description'];

// In config
'use_fallback' => true,
'fallback_locale' => 'ar',
```

### 2. Generate Slug from Primary Language
```php
// Only generate slug from Arabic (primary language)
->afterStateUpdated(function ($state, Forms\Set $set, $livewire) {
    if ($livewire->activeLocale === 'ar') {
        $set('slug', \Illuminate\Support\Str::slug($state));
    }
})
```

### 3. Use Translation Helpers
```blade
<!-- Use __() helper -->
{{ __('navbar.home') }}

<!-- Use trans_choice() for plurals -->
{{ trans_choice('common.products', $count) }}
```

### 4. Handle Missing Translations
```php
// In views
{{ $product->name ?? 'N/A' }}

// Or with fallback
{{ $product->getTranslation('name', app()->getLocale(), false) ?? $product->name }}
```

### 5. Cache Translations
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🎯 Quick Start Checklist

- [ ] Install packages: `composer require spatie/laravel-translatable filament/spatie-laravel-translatable-plugin`
- [ ] Run migrations: `php artisan migrate`
- [ ] Add `HasTranslations` trait to models
- [ ] Define `$translatable` array in models
- [ ] Add `Translatable` concern to Filament resources
- [ ] Update layout with `LocaleHelper`
- [ ] Add language switcher to navbar
- [ ] Create translation files (ar, en, fr)
- [ ] Test language switching
- [ ] Test RTL/LTR layouts
- [ ] Test Filament admin translations

---

## 📚 Additional Resources

- [Spatie Laravel Translatable Docs](https://github.com/spatie/laravel-translatable)
- [Filament Translatable Plugin](https://filamentphp.com/plugins/filament-spatie-translatable)
- [Laravel Localization](https://laravel.com/docs/localization)

---

## 🆘 Troubleshooting

### Issue: Translations not saving
**Solution**: Ensure columns are JSON type in database
```php
$table->json('name')->change();
```

### Issue: Language not switching
**Solution**: Check middleware is registered and session is working
```bash
php artisan optimize:clear
```

### Issue: RTL not working
**Solution**: Verify HTML dir attribute
```blade
<html dir="{{ LocaleHelper::htmlDir() }}">
```

### Issue: Filament tabs not showing
**Solution**: Ensure plugin is registered in panel provider
```php
->plugins([
    SpatieLaravelTranslatablePlugin::make()
        ->defaultLocales(['ar', 'en', 'fr']),
])
```

---

## 🎉 Congratulations!

Your SOOQLINK platform now supports full multilingual functionality with seamless RTL/LTR switching!

**Happy Coding! 🚀**

