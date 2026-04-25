<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Delivery extends Model
{
    protected $fillable = [
        'delivery_number',
        'destination',
        'destination_type',
        'status',
        'shipped_at',
        'delivered_at',
        'note',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function warehouses(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function productVariants(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class)
            ->using(DeliveryItem::class);
    }

}
