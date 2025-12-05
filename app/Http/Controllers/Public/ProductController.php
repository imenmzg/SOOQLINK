<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Product::query()
                ->with(['supplier', 'category'])
                ->published()
                ->verifiedSuppliers();

            // Filters
            if ($request->filled('category')) {
                $query->byCategory($request->category);
            }

            if ($request->filled('wilaya')) {
                $query->byWilaya($request->wilaya);
            }

            if ($request->filled('min_price') && $request->filled('max_price')) {
                $query->priceRange($request->min_price, $request->max_price);
            }

            // Search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Sorting
            $sort = $request->get('sort', 'newest');
            match ($sort) {
                'price_low' => $query->orderByPrice('asc'),
                'price_high' => $query->orderByPrice('desc'),
                'rating' => $query->orderByRating(),
                default => $query->orderByNewest(),
            };

            // Cursor pagination
            $products = $query->cursorPaginate(20);
        } catch (\Exception $e) {
            // If products table doesn't exist, return empty paginator
            $products = new \Illuminate\Pagination\CursorPaginator([], 20, null, []);
        }

        try {
            $categories = Category::active()->ordered()->get();
        } catch (\Exception $e) {
            $categories = collect([]);
        }
        
        $wilayas = collect(config('wilayas'))->sort()->values();

        return view('public.products.index', compact('products', 'categories', 'wilayas'));
    }

    public function show($slug)
    {
        try {
            $product = Product::where('slug', $slug)
                ->with(['supplier.user', 'category', 'supplier.reviews'])
                ->published()
                ->verifiedSuppliers()
                ->firstOrFail();

            $product->incrementViews();

            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->published()
                ->verifiedSuppliers()
                ->limit(6)
                ->get();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Exception $e) {
            // If products table doesn't exist, show 404
            abort(404);
        }

        return view('public.products.show', compact('product', 'relatedProducts'));
    }

    public function apiIndex(Request $request)
    {
        try {
            $query = Product::query()
                ->with(['supplier', 'category'])
                ->published()
                ->verifiedSuppliers();

            // Apply same filters as web
            if ($request->filled('category')) {
                $query->byCategory($request->category);
            }

            if ($request->filled('wilaya')) {
                $query->byWilaya($request->wilaya);
            }

            if ($request->filled('min_price') && $request->filled('max_price')) {
                $query->priceRange($request->min_price, $request->max_price);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $sort = $request->get('sort', 'newest');
            match ($sort) {
                'price_low' => $query->orderByPrice('asc'),
                'price_high' => $query->orderByPrice('desc'),
                'rating' => $query->orderByRating(),
                default => $query->orderByNewest(),
            };

            $products = $query->cursorPaginate(20);
        } catch (\Exception $e) {
            // If products table doesn't exist, return empty response
            $products = new \Illuminate\Pagination\CursorPaginator([], 20, null, []);
        }

        return response()->json([
            'data' => $products->items(),
            'next_cursor' => $products->nextCursor()?->encode(),
            'has_more' => $products->hasMorePages(),
        ]);
    }
}

