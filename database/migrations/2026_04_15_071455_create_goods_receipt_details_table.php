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
        Schema::create('goods_receipt_details', function (Blueprint $table) {
            $table->id();
            $table->decimal('qty_received')->default(0);
            $table->decimal('qty_accepted')->default(0);
            $table->decimal('qty_rejected')->default(0);
            $table->decimal('unit_price')->default(0);
            $table->enum('qc_status', [
                'pending',
                'received',
                'partial_received',
                'waiting_qc',
                'qc_passed',
                'qc_failed',
                'rejected',
                'returned',
            ])->default('pending');
            $table->text('qc_note')->nullable();
            $table->dateTime('qc_at')->nullable();

            $table->foreignId('goods_receipt_id')
                ->constrained('goods_receipts')
                ->cascadeOnDelete();
            $table->foreignId('purchase_order_detail_id')
                ->constrained('purchase_orders')
                ->restrictOnDelete();
            $table->foreignId('product_variant_id')
                ->constrained('product_variants')
                ->cascadeOnDelete();
            $table->foreignId('warehouse_rack_id')
                ->nullable()
                ->constrained('warehouse_racks')
                ->restrictOnDelete();
            $table->foreignId('qc_by')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();
            $table->timestamps();

            $table->unique(['goods_receipt_id', 'product_variant_id'], 'gr_product_unique');
            $table->index('qc_status', 'idx_gr_detail_qc_status');
            $table->index('qc_at', 'idx_gr_detail_qc_at');
            $table->index('goods_receipt_id', 'idx_gr_detail_gr_id');
            $table->index('product_variant_id', 'idx_gr_detail_prod_vary_id');
            $table->index('purchase_order_detail_id', 'idx_gr_detail_po_detail_id');
            $table->index('warehouse_rack_id', 'idx_gr_detail_rack_id');
            $table->index('qc_by', 'idx_gr_detail_qc_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_details');
    }
};
