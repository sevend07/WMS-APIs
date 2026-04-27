<?php

namespace App\Models;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    /** @use HasFactory<\Database\Factories\ProductVariantFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sku',
        'size',
        'color',
        'price',
    ];

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'product_suppliers');
    }

    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(WarehouseRack::class)
            ->using(Inventory::class);
    }

    public function purchaseOrders(): BelongsToMany
    {
        return $this->belongsToMany(PurchaseOrder::class)
            ->using(PurchaseOrderDetail::class);
    }

    public function goodReceipts(): BelongsToMany
    {
        return $this->belongsToMany(GoodsReceipt::class)
            ->using(GoodsReceiptDetail::class);
    }

    public function deliveries(): BelongsToMany
    {
        return $this->belongsToMany(Delivery::class)
            ->using(DeliveryItem::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
