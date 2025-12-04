# 🌍 How to Use Translations in Your Blade Files

## ✅ Language Switcher is Now Working!

The language switcher has been fixed with:
- ✅ Proper route: `/language/{locale}`
- ✅ Alpine.js loaded in layout
- ✅ Session-based language storage
- ✅ Automatic redirect back to previous page

---

## 🔄 How Language Switching Works

1. User clicks language switcher (globe icon)
2. Selects a language (AR/EN/FR)
3. Request goes to: `GET /language/{locale}`
4. `LanguageController` stores locale in session
5. User is redirected back to the same page
6. Page reloads with new language

---

## 📝 How to Translate Content in Blade Files

### Method 1: Use Translation Files (Recommended)

**For static text (navbar, buttons, labels):**

```blade
<!-- Instead of hardcoded text -->
<a href="{{ route('home') }}">الرئيسية</a>

<!-- Use translation helper -->
<a href="{{ route('home') }}">{{ __('navbar.home') }}</a>
```

**Result:**
- Arabic: الرئيسية
- English: Home
- French: Accueil

### Method 2: Use Model Translations (For Database Content)

**For dynamic content (categories, products):**

```blade
<!-- Product name (automatically uses current locale) -->
<h2>{{ $product->name }}</h2>

<!-- Category description -->
<p>{{ $category->description }}</p>
```

**How it works:**
- When locale is `ar`: Shows Arabic text
- When locale is `en`: Shows English text
- When locale is `fr`: Shows French text

---

## 🎯 Quick Examples

### Example 1: Navbar Links

**Before (hardcoded Arabic):**
```blade
<a href="{{ route('home') }}">الرئيسية</a>
<a href="{{ route('suppliers.index') }}">الموردين</a>
<a href="{{ route('products.index') }}">المنتجات</a>
```

**After (translatable):**
```blade
<a href="{{ route('home') }}">{{ __('navbar.home') }}</a>
<a href="{{ route('suppliers.index') }}">{{ __('navbar.suppliers') }}</a>
<a href="{{ route('products.index') }}">{{ __('navbar.products') }}</a>
```

### Example 2: Buttons

**Before:**
```blade
<button>تسجيل الدخول</button>
<button>تسجيل</button>
```

**After:**
```blade
<button>{{ __('navbar.login') }}</button>
<button>{{ __('navbar.register') }}</button>
```

### Example 3: Common Words

**Before:**
```blade
<span>متوفر</span>
<span>غير متوفر</span>
<span>السعر</span>
```

**After:**
```blade
<span>{{ __('common.available') }}</span>
<span>{{ __('common.unavailable') }}</span>
<span>{{ __('common.price') }}</span>
```

### Example 4: Product Display

**Before (hardcoded):**
```blade
<div class="product-card">
    <h3>{{ $product->name }}</h3>
    <p>السعر: {{ $product->price }} DZD</p>
    <span>متوفر</span>
</div>
```

**After (translatable):**
```blade
<div class="product-card">
    <h3>{{ $product->name }}</h3> <!-- Auto-translates based on locale -->
    <p>{{ __('common.price') }}: {{ $product->price }} DZD</p>
    <span>{{ __('common.available') }}</span>
</div>
```

---

## 📚 Available Translation Keys

### Navbar (`navbar.php`)
```php
__('navbar.home')       // الرئيسية / Home / Accueil
__('navbar.suppliers')  // الموردين / Suppliers / Fournisseurs
__('navbar.products')   // المنتجات / Products / Produits
__('navbar.dashboard')  // لوحة التحكم / Dashboard / Tableau de bord
__('navbar.login')      // الدخول / Login / Connexion
__('navbar.register')   // تسجيل / Register / S'inscrire
```

### Common (`common.php`)
```php
__('common.verified')     // موثق / Verified / Vérifié
__('common.available')    // متوفر / Available / Disponible
__('common.unavailable')  // غير متوفر / Unavailable / Indisponible
__('common.search')       // بحث / Search / Rechercher
__('common.filter')       // تصفية / Filter / Filtrer
__('common.reset')        // إعادة تعيين / Reset / Réinitialiser
__('common.apply')        // تطبيق / Apply / Appliquer
__('common.view_details') // عرض التفاصيل / View Details / Voir les détails
__('common.request_quote')// طلب عرض سعر / Request Quote / Demander un devis
__('common.send_message') // إرسال رسالة / Send Message / Envoyer un message
__('common.load_more')    // تحميل المزيد / Load More / Charger plus
__('common.no_results')   // لا توجد نتائج / No Results / Aucun résultat
__('common.price')        // السعر / Price / Prix
__('common.quantity')     // الكمية / Quantity / Quantité
__('common.location')     // الموقع / Location / Emplacement
__('common.category')     // الفئة / Category / Catégorie
__('common.rating')       // التقييم / Rating / Évaluation
```

---

## 🔧 How to Add New Translations

### Step 1: Add to Arabic file
**File:** `lang/ar/common.php`
```php
return [
    // ... existing translations
    'new_key' => 'النص بالعربية',
];
```

### Step 2: Add to English file
**File:** `lang/en/common.php`
```php
return [
    // ... existing translations
    'new_key' => 'Text in English',
];
```

### Step 3: Add to French file
**File:** `lang/fr/common.php`
```php
return [
    // ... existing translations
    'new_key' => 'Texte en français',
];
```

### Step 4: Use in Blade
```blade
{{ __('common.new_key') }}
```

---

## 🎨 Example: Update Home Page Hero

**Current (hardcoded Arabic):**
```blade
<h1 class="text-4xl font-bold">
    اربط شركتك
    <span class="block mt-2" style="color: #32A7E2;">بالموردين الموثوقين</span>
</h1>
<p class="text-lg text-slate-600">
    منصة احترافية تربط الشركات بالموردين الموثوقين
</p>
```

**Updated (translatable):**

1. **Add to translation files:**

`lang/ar/home.php`:
```php
return [
    'hero_title_1' => 'اربط شركتك',
    'hero_title_2' => 'بالموردين الموثوقين',
    'hero_subtitle' => 'منصة احترافية تربط الشركات بالموردين الموثوقين',
];
```

`lang/en/home.php`:
```php
return [
    'hero_title_1' => 'Connect Your Business',
    'hero_title_2' => 'With Trusted Suppliers',
    'hero_subtitle' => 'Professional platform connecting businesses with trusted suppliers',
];
```

`lang/fr/home.php`:
```php
return [
    'hero_title_1' => 'Connectez Votre Entreprise',
    'hero_title_2' => 'Avec Des Fournisseurs De Confiance',
    'hero_subtitle' => 'Plateforme professionnelle reliant les entreprises aux fournisseurs de confiance',
];
```

2. **Update Blade:**
```blade
<h1 class="text-4xl font-bold">
    {{ __('home.hero_title_1') }}
    <span class="block mt-2" style="color: #32A7E2;">{{ __('home.hero_title_2') }}</span>
</h1>
<p class="text-lg text-slate-600">
    {{ __('home.hero_subtitle') }}
</p>
```

---

## 🧪 Testing

### Test 1: Visit Homepage
1. Go to `http://localhost:8000`
2. Page should be in Arabic (default)

### Test 2: Switch to English
1. Click globe icon (language switcher)
2. Click "English"
3. Page reloads
4. Navbar should show: Home, Suppliers, Products
5. Layout should flip to LTR (left-to-right)

### Test 3: Switch to French
1. Click globe icon
2. Click "Français"
3. Page reloads
4. Navbar should show: Accueil, Fournisseurs, Produits
5. Layout should remain LTR

### Test 4: Switch back to Arabic
1. Click globe icon
2. Click "العربية"
3. Page reloads
4. Navbar should show: الرئيسية, الموردين, المنتجات
5. Layout should flip to RTL (right-to-left)

---

## 🚨 Important Notes

### 1. Database Content (Categories, Products)
These are already translatable! Just add translations in the admin panel:
- Go to Admin → Categories → Edit
- You'll see tabs: AR | EN | FR
- Enter translations for each language
- Save

### 2. Static Content (Navbar, Buttons, Labels)
Use translation files:
```blade
{{ __('navbar.home') }}
{{ __('common.price') }}
```

### 3. Mixed Content
```blade
<!-- Static text with dynamic data -->
<p>{{ __('common.price') }}: {{ $product->price }} DZD</p>

<!-- Translatable model field -->
<h2>{{ $product->name }}</h2>
```

---

## 🎯 Quick Checklist

To make a page translatable:

- [ ] Replace hardcoded Arabic text with `{{ __('file.key') }}`
- [ ] Add translations to `lang/ar/`, `lang/en/`, `lang/fr/`
- [ ] Test language switching
- [ ] Verify RTL/LTR layout changes
- [ ] Check that model fields (categories, products) auto-translate

---

## 📞 Need More Translations?

Just add them to the language files:

**Example: Add "Contact Us"**

1. `lang/ar/common.php`: `'contact_us' => 'اتصل بنا'`
2. `lang/en/common.php`: `'contact_us' => 'Contact Us'`
3. `lang/fr/common.php`: `'contact_us' => 'Contactez-nous'`
4. Use: `{{ __('common.contact_us') }}`

---

## 🎉 Summary

✅ **Language Switcher**: Working (click globe icon)
✅ **Route**: `/language/{locale}` 
✅ **Session**: Stores selected language
✅ **Auto-redirect**: Returns to same page
✅ **RTL/LTR**: Automatic layout switching
✅ **Translations**: Use `{{ __('file.key') }}`
✅ **Models**: Auto-translate (categories, products)

**Your platform is now multilingual! 🌍🚀**

