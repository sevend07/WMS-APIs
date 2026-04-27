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
        Schema::create('product_suppliers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_variant_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('supplier_id')
                ->constrained('suppliers')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['product_variant_id', 'supplier_id'], 'product_supplier_unique');
            $table->unique(['supplier_id', 'product_variant_id'], 'supplier_product_unique');
            $table->index('product_variant_id', 'idx_prod_supp_prod_vary_id');
            $table->index('supplier_id', 'idx_prod_supp_supp_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_suppliers');
    }
};
