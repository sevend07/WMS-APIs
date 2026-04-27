<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoodsReceiptDetail extends Model
{
    protected $fillable = [
        'qty_received',
        'qty_accepted',
        'qty_rejected',
        'unit_price',
        'qc_status',
        'qc_note',
        'qc_at',
    ];

    public function goodsReceipts(): BelongsTo
    {
        return $this->belongsTo(GoodsReceipt::class);
    }

    public function purchaseOrderDetails(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrderDetail::class);
    }

    public function products(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function warehouseRacks(): BelongsTo
    {
        return $this->belongsTo(WarehouseRack::class);
    }

    public function inspectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'qc_by');
    }
}
