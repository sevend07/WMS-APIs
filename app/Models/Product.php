<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'name',
        'description',
        'brand_id',
        'category_id',
    ];

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    protected static function booted(): void
    {
        static::deleting(function ($product) {
            if (! $product->isForceDeleting()) {
                $product->productVariants()->delete();
            } else {
                $product->productVariants()->forceDelete();
            }
        });

        static::restoring(function ($product) {
            $product->productVariants()
                ->withTrashed()
                ->restore();
        });
    }

    /**
     * BUSSINES LOGIC
     * 
     * @ increase, decrease, update stock
     * @ validation: has enough? is available? is low? out of stock?
     * @ code generation
     * @ filtering
     * 
     */
}
