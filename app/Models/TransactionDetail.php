<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TransactionDetail extends Pivot
{
    /** @use HasFactory<\Database\Factories\TransactionDetailFactory> */
    use HasFactory;

    public function transactions(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
