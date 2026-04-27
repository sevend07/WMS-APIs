<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->integer('qty');
            $table->integer('min_stock');
            $table->integer('max_stock');
            $table->foreignId('product_variant_id')
                ->constrained('product_variants')
                ->restrictOnDelete();
            $table->foreignId('warehouse_id')
                ->constrained('warehouses')
                ->restrictOnDelete();
            $table->foreignId('warehouse_rack_id')
                ->constrained('warehouse_racks')
                ->restrictOnDelete();
            $table->timestamps();

            $table->unique(['product_variant_id', 'warehouse_rack_id'], 'product_per_rack_unique');
            $table->index(['product_variant_id', 'warehouse_id'], 'idx_product_warehouse_inventory');
            $table->index('product_variant_id', 'idx_product_inventory');
            $table->index('warehouse_id', 'idx_warehouse_inventory');
            $table->index('warehouse_rack_id', 'idx_rack_inventory');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_inventories');
    }
};
