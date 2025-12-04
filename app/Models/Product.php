<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'supplier_id',
        'category_id',
        'name',
        'slug',
        'description',
        'technical_details',
        'price',
        'quantity',
        'wilaya',
        'location',
        'is_published',
        'views_count',
    ];

    public $translatable = ['name', 'description', 'technical_details'];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'quantity' => 'integer',
            'is_published' => 'boolean',
            'views_count' => 'integer',
        ];
    }

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . uniqid();
            }
        });
    }

    // Relationships
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function rfqs(): HasMany
    {
        return $this->hasMany(RFQ::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByWilaya($query, $wilaya)
    {
        return $query->where('wilaya', $wilaya);
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    public function scopeVerifiedSuppliers($query)
    {
        return $query->whereHas('supplier', function ($q) {
            $q->verified()->active();
        });
    }

    public function scopeOrderByNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOrderByPrice($query, $direction = 'asc')
    {
        return $query->orderBy('price', $direction);
    }

    public function scopeOrderByRating($query)
    {
        return $query->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->orderBy('suppliers.average_rating', 'desc')
            ->select('products.*');
    }

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->onlyKeepLatest(6);
    }

    // Helpers
    public function incrementViews()
    {
        $this->increment('views_count');
    }
}

