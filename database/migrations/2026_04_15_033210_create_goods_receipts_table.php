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
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->integer('gr_number')->unique('gr_number_unique');

            $table->enum('status', [
                'draft',
                'waiting_arrival',
                'partial_received',
                'waiting_qc',
                'rejected',
                'cencelled',
                'complete'
            ])->default('draft');

            $table->dateTime('received_at');
            $table->text('note')->nullable();

            $table->foreignId('purchase_order_id')
                ->constrained('purchase_orders')
                ->cascadeOnDelete();
            $table->foreignId('warehouse_id')
                ->constrained('warehouses')
                ->restrictOnDelete();
            $table->foreignId('received_by')
                ->constrained('users')
                ->restrictOnDelete();
            
            $table->timestamps();

            $table->index('status', 'idx_gr_status');
            $table->index('received_at', 'idx_gr_received_at');
            $table->index('purchase_order_id', 'idx_gr_po_id');
            $table->index('warehouse_id', 'idx_gr_warehouse_id');
            $table->index('received_by', 'idx_gr_received_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};
