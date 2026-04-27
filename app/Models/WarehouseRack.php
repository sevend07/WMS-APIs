<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WarehouseRack extends Model
{
    protected $fillable = [
        'name'
    ];

    public function warehouseZones(): BelongsTo
    {
        return $this->belongsTo(WarehouseZone::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class)
            ->using(Inventory::class);
    }

    public function goodsReceiptDetails(): HasMany
    {
        return $this->hasMany(GoodsReceiptDetail::class);
    }

    public function deliveryItems(): HasMany
    {
        return $this->hasMany(DeliveryItem::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
