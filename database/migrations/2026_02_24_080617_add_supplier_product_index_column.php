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
        Schema::table('supplier_products', function (Blueprint $table) {
            $table->index(['product_id', 'supplier_id']);
            $table->index(['supplier_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('supplier_products', function (Blueprint $table) {
            $table->dropIndex(['product_id', 'supplier_id']);
            $table->dropIndex(['supplier_id', 'product_id']);
        });
    }
};
