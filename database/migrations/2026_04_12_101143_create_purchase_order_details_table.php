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
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->decimal('qty_order');
            $table->decimal('qty_received')->default(0);
            $table->decimal('unit_price');
            $table->decimal('tax')->default(0);
            // $table->decimal('subtotal') || NEED VIRTUAL COLUMN || qty * unit_price;
            $table->foreignId('purchase_order_id')
                ->constrained('purchase_orders')
                ->cascadeOnDelete();
            $table->foreignId('product_variant_id')
                ->constrained('product_variants')
                ->restrictOnDelete();
            $table->timestamps();

            $table->unique(['purchase_order_id', 'product_variant_id'], 'po_product_variant_unique');
            $table->index('purchase_order_id', 'idx_detail_po');
            $table->index('product_variant_id', 'idx_detail_product');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_details');
    }
};
