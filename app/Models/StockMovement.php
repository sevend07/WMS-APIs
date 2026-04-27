<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $fillable = [
        'movement_type',
        'reference_no',
        'qty',
        'qty_before',
        'qty_after',
        'unit_price',
        'note',
    ];

    public function products(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function warehouses(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function warehouseRacks(): BelongsTo
    {
        return $this->belongsTo(WarehouseRack::class);
    }
}
