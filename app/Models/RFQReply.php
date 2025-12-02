<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RFQReply extends Model
{
    use HasFactory;

    protected $table = 'rfq_replies';

    protected $fillable = [
        'rfq_id',
        'supplier_id',
        'price',
        'message',
        'delivery_date',
        'terms',
        'is_accepted',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'delivery_date' => 'date',
            'is_accepted' => 'boolean',
        ];
    }

    // Relationships
    public function rfq(): BelongsTo
    {
        return $this->belongsTo(RFQ::class, 'rfq_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}

