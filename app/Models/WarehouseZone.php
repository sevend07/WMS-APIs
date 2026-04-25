<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WarehouseZone extends Model
{
    protected $fillable = [
        'name'
    ];

    public function warehouses(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function warehouseRacks(): HasMany
    {
        return $this->hasMany(WarehouseRack::class);
    }
}
