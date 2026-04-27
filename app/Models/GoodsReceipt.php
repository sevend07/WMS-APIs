<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GoodsReceipt extends Model
{
    protected $fillable = [
        'status',
        'receive_at',
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

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class)
            ->using(GoodsReceiptDetail::class);
    }
}
