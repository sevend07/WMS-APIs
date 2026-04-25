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
        Schema::create('item_inventories', function (Blueprint $table) {
            $table->id();
            $table->integer('qty');
            $table->integer('min_stock');
            $table->integer('max_stock');
            $table->foreignId('item_id')
                ->constrained('items')
                ->restrictOnDelete();
            $table->foreignId('warehouse_id')
                ->constrained('warehouses')
                ->restrictOnDelete();
            $table->timestamps();

            $table->unique(['item_id', 'warehouse_id', 'item_warehouse_unique']);
            $table->index('item_id', 'idx_item_inventory');
            $table->index('warehouse_id', 'idx_item_warehouse');
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
