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
            $table->foreignId('material_id')
                ->constrained('materials')
                ->restrictOnDelete();
            $table->timestamps();

            $table->unique(['purchase_order_id', 'material_id'], 'po_material_unique');
            $table->index('purchase_order_id', 'idx_detail_po');
            $table->index('material_id', 'idx_detail_material');
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
