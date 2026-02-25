<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'notes',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'transaction_details')
            ->using(TransactionDetail::class);
    }

    public function suppliers(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
