<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Language Switcher Route
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('/', function () {
    try {
        $categories = \App\Models\Category::active()->ordered()->limit(8)->get();
    } catch (\Exception $e) {
        // If categories table doesn't exist, use empty collection
        $categories = collect([]);
    }
    
    try {
        $featuredProducts = \App\Models\Product::published()
            ->verifiedSuppliers()
            ->orderByNewest()
            ->limit(12)
            ->get();
    } catch (\Exception $e) {
        // If products table doesn't exist, use empty collection
        $featuredProducts = collect([]);
    }
    
    // Safely get counts for stats
    try {
        $suppliersCount = \App\Models\Supplier::verified()->count();
    } catch (\Exception $e) {
        $suppliersCount = 0;
    }
    
    try {
        $productsCount = \App\Models\Product::published()->count();
    } catch (\Exception $e) {
        $productsCount = 0;
    }
    
    try {
        $categoriesCount = \App\Models\Category::active()->count();
    } catch (\Exception $e) {
        $categoriesCount = 0;
    }
    
    return view('public.home', compact('categories', 'featuredProducts', 'suppliersCount', 'productsCount', 'categoriesCount'));
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/suppliers', function (\Illuminate\Http\Request $request) {
    try {
        $query = \App\Models\Supplier::verified()
            ->with(['user', 'products' => function ($q) {
                $q->published();
            }]);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('company_description', 'like', "%{$search}%")
                  ->orWhere('wilaya', 'like', "%{$search}%");
            });
        }
        
        // Sort by rating if requested
        if ($request->filled('sort') && $request->sort === 'rating') {
            $query->orderBy('average_rating', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        
        $suppliers = $query->paginate(12);
    } catch (\Exception $e) {
        // If suppliers table doesn't exist, return empty paginator
        $suppliers = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12, 1);
    }
    
    return view('public.suppliers.index', compact('suppliers'));
})->name('suppliers.index');

Route::get('/supplier/{id}', function ($id) {
    try {
        $supplier = \App\Models\Supplier::with(['user', 'products' => function ($q) {
            $q->published();
        }, 'reviews'])->verified()->findOrFail($id);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        abort(404);
    } catch (\Exception $e) {
        // If suppliers table doesn't exist, show 404
        abort(404);
    }
    
    return view('public.supplier.show', compact('supplier'));
})->name('supplier.show');

// API routes for cursor pagination
Route::prefix('api')->group(function () {
    Route::get('/products', [ProductController::class, 'apiIndex'])->name('api.products.index');
});

// Admin document download route
Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/admin/supplier-documents/{supplierDocument}/download', [\App\Http\Controllers\Admin\SupplierDocumentController::class, 'download'])
        ->name('admin.supplier-documents.download');
});

