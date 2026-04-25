<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GoodsReceipt extends Model
{
    protected $fillable = [
        'status',
        'note',
    ];

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function purchaseOrders(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function warehouses(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function goodsReceiptDetails(): HasMany
    {
        return $this->hasMany(GoodsReceiptDetail::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class)
            ->using(GoodsReceiptDetail::class);
    }
}
