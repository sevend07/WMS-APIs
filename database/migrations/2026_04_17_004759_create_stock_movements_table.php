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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->integer('reference_no');
            $table->enum('movement_type', [
                'stock_in',
                'stock_out',
                'adjustment_in',
                'adjustment_out'
            ]);
            $table->integer('qty');
            $table->integer('qty_before');
            $table->integer('qty_after');
            $table->decimal('unit_price');
            $table->text('note');

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

            $table->index('product_variant_id', 'idx_stock_movement_product');
            $table->index('warehouse_id', 'idx_stock_movement_warehouse');
            $table->index('warehouse_rack_id', 'idx_stock_movement_rack');
            $table->index('reference_no', 'idx_stock_movement_ref');
            $table->index('movement_type', 'idx_stock_movement_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
