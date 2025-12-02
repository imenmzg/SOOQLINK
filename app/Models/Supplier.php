<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Supplier extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_description',
        'commercial_register_number',
        'tax_card_number',
        'phone',
        'address',
        'wilaya',
        'location',
        'verification_status',
        'rejection_reason',
        'verified_at',
        'average_rating',
        'total_reviews',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'average_rating' => 'decimal:2',
            'total_reviews' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(SupplierDocument::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function publishedProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_published', true);
    }

    public function rfqs(): HasMany
    {
        return $this->hasMany(RFQ::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByWilaya($query, $wilaya)
    {
        return $query->where('wilaya', $wilaya);
    }

    // Helpers
    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }

    public function updateRating()
    {
        // Only count approved reviews (the reviews() relationship already filters by is_approved = true)
        $approvedReviews = $this->reviews()->get();
        $this->average_rating = $approvedReviews->avg('rating') ?? 0.00;
        $this->total_reviews = $approvedReviews->count();
        $this->save();
    }

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents')
            ->acceptsMimeTypes(['application/pdf', 'image/jpeg', 'image/png']);
    }
}

