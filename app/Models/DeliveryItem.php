<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryItem extends Model
{
    protected $fillable = [
        'qty_order',
        'qty_shipped',
    ];

    public function deliveries(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    public function products(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function warehouse_racks(): BelongsTo
    {
        return $this->belongsTo(WarehouseRack::class);
    }
}
