<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'movement_type',
        'reference_no',
        'qty',
        'qty_before',
        'qty_after',
        'unit_cost',
        'note',
    ];
}
