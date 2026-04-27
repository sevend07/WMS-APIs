<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderDetail extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseOrderDetailFactory> */
    use HasFactory;

    protected $fillable = [
        'qty_order',
        'qty_received',
        'unit_price',
        'tax',
    ];

    public function purchaseOrders(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function products(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
