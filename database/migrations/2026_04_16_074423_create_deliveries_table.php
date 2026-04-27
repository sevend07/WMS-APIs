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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_number')->unique('delivery_number_unique');
            $table->string('destination');
            $table->enum('destination_type', ['store', 'distributor']);

            $table->enum('status', [
                'draft',
                'cencelled',
                'picking',
                'packed',
                'shipped',
                'partial_sipped',
                'delivered',
                'complete',
            ])->default('draft');

            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->text('note')->nullable();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('warehouse_id')
                ->constrained('warehouses')
                ->restrictOnDelete();
            $table->timestamps();

            $table->index('destination_type', 'idx_delivery_destination_type');
            $table->index('status', 'idx_delivery_status');
            $table->index('shipped_at', 'idx_delivery_shipped_at');
            $table->index('delivered_at', 'idx_delivery_deliered_at');
            $table->index('created_by', 'idx_delivery_created_by_user_id');
            $table->index('warehouse_id', 'idx_delivery_warehouse_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
