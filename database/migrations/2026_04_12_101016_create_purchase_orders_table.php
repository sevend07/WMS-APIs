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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('po_number')->unique('po_number_unique');
            $table->decimal('total_amount');
            $table->string('currency');

            $table->enum('status', [
                'draft',
                'pending',
                'released',
                'partial',
                'closed',
                'cencelled',
            ])->default('draft');

            $table->dateTime('order_date');
            $table->date('expected_delivery_date');
            $table->text('note')->nullable();

            $table->foreignId('supplier_id')
                ->constrained('suppliers')
                ->restrictOnDelete();
            $table->foreignId('warehouse_id')
                ->constrained('warehouses')
                ->restrictOnDelete();
            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();
                
            $table->timestamps();

            $table->index('currency', 'idx_po_currency');
            $table->index('status', 'idx_po_status');
            $table->index('order_date', 'idx_po_date');
            $table->index('supplier_id', 'idx_po_supplier_id');
            $table->index('warehouse_id', 'idx_po_warehouse_id');
            $table->index('created_by', 'idx_po_created_by_user_id');
            $table->index('approved_by', 'idx_po_approved_by_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
