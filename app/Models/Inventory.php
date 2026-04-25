<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $fillable = [
        'qty',
        'min_stock',
        'max_stock'
    ];

    public function products(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function warehouses(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }
}
