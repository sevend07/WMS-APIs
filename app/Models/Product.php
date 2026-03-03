<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'name',
        'unit',
        'min_stock',
    ];

    protected $attributes = [
        'stock' => 0,
    ];

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(Supplier::class, 'supplier_products')
            ->withTimestamps();
    }

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class)
            ->using(TransactionDetail::class);
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

    /**
     * Generate unique product code
     */
    public static function generateCode(string $prefix = 'PRD'): string
    {
        $lastProduct = self::where('code', 'like', "{$prefix}%")
            ->latest('id')
            ->first();

        if (!$lastProduct) {
            return "{$prefix}-0001";
        }

        $lastNumber = (int) substr($lastProduct->code, -4);
        $newNumber = $lastNumber + 1;

        return sprintf('%s-%04d', $prefix, $newNumber);
    }

    /**
     * Auto-generate code on creation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (!$product->code) {
                $product->code = self::generateCode();
            }
        });
    }

    /** PRODUCT 
     * 
     * @validation
     * @management
     * @filter
     * 
     */

    public function hasEnoughStock(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }

    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }

    public function isLowStock(): bool
    {
        return $this->stock > 0 && $this->stock <= $this->min_stock;
    }

    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    public function increaseStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }

    public function decreaseStock(int $quantity): void
    {
        if ($this->stock < $quantity) {
            throw new \Exception(
                "Stock {$this->name} tidak cukup. Tersedia: {$this->stock}, Dibutuhkan: {$quantity}"
            );
        }

        $this->decrement('stock', $quantity);
    }

    public function updateStock(int $quantity, string $type): void
    {
        if ($type === 'in') {
            $this->increaseStock($quantity);
        } elseif ($type === 'out') {
            $this->decreaseStock($quantity);
        }
    }

    /** Search */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
        ];
    }

    /** Scopes */

    #[Scope]
    protected function lowStock(Builder $query)
    {
        return $query->where('stock_status', 'low');
    }

    #[Scope]
    protected function outOfStock(Builder $query)
    {
        return $query->where('stock_status', 'empty');
    }

    #[Scope]
    protected function available(Builder $query)
    {
        return $query->where('stock', 'available');
    }

    // #[Scope]
    // protected function search($query, string $keyword)
    // {
    //     return $query->where(function ($q) use ($keyword) {
    //         $q->where('name', 'like', "%{$keyword}%")
    //             ->orWhere('code', 'like', "%{$keyword}%");
    //     });
    // }

    #[Scope]
    protected function filter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, function ($query, $status) {
            match ($status) {
                'available' => $query->available(),
                'low' => $query->lowStock(),
                'empty' => $query->outOfStock(),
                default => null
            };
        });

        $query->when($filters['has_supplier'] ?? null, function ($query, $hasSupplier) {
            match ($hasSupplier) {
                'true' => $query->hasSupplier(),
                'false' => $query->withOutSupplier(),
                default => null
            };
        });
    }

    #[Scope]
    protected function hasSupplier($query)
    {
        return $query->whereHas('suppliers');
    }

    #[Scope]
    protected function withOutSupplier($query)
    {
        return $query->whereDoesntHave('suppliers');
    }

    /** SUPPLIER */

    public function getAllSuppliers()
    {
        return $this->suppliers()->get();
    }

    public function addSupplier(int $supplierId): void
    {
        if (!$this->suppliers()->where('supplier_id', $supplierId)->exists()) {
            $this->suppliers()->attach($supplierId);
        }
    }
}
