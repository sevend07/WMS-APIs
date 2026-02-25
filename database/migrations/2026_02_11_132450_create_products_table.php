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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('unit');
            $table->integer('stock')->default(0);
            $table->integer('min_stock');
            $table->string('stock_status', 20)->virtualAs(
                "CASE 
                    WHEN stock <= 0 THEN 'empty'
                    WHEN stock > 0 AND stock <= min_stock THEN 'low'
                    ELSE 'available'
                END"
            );
            $table->index('name');
            $table->index('code');
            $table->index('stock_status');
            $table->index(['stock', 'min_stock']);
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
