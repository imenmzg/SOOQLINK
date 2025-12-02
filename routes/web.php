<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $categories = \App\Models\Category::active()->ordered()->limit(8)->get();
    $featuredProducts = \App\Models\Product::published()
        ->verifiedSuppliers()
        ->orderByNewest()
        ->limit(12)
        ->get();
    
    return view('public.home', compact('categories', 'featuredProducts'));
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/suppliers', function (\Illuminate\Http\Request $request) {
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
    
    return view('public.suppliers.index', compact('suppliers'));
})->name('suppliers.index');

Route::get('/supplier/{id}', function ($id) {
    $supplier = \App\Models\Supplier::with(['user', 'products' => function ($q) {
        $q->published();
    }, 'reviews'])->verified()->findOrFail($id);
    
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

