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
        Schema::create('delivery_items', function (Blueprint $table) {
            $table->id();
            $table->decimal('qty_order');
            $table->decimal('qty_shipped')->default(0);

            $table->foreignId('delivery_id')
                ->constrained('deliveries')
                ->restrictOnDelete();
            $table->foreignId('product_variant_id')
                ->constrained('product_variants')
                ->restrictOnDelete();
            $table->foreignId('warehouse_rack_id')
                ->constrained('warehouse_racks')
                ->restrictOnDelete();

            $table->timestamps();

            $table->unique(['delivery_id', 'product_variant_id'], 'deliv_item_prod_unique');
            $table->index('delivery_id', 'idx_deliv_item_deliv_id');
            $table->index('product_variant_id', 'idx_deliv_item_prod_vary_id');
            $table->index('warehouse_rack_id', 'idx_deliv_item_rack_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_items');
    }
};
