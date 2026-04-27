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
            $table->text('description')->nullable();

            $table->foreignId('brand_id')
                ->constrained('brands')
                ->restrictOnDelete();
            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(
                ['name', 'brand_id', 'category_id', 'deleted_at'],
                'prod_name_brand_category_unique'
            );
            $table->index(['category_id', 'brand_id'], 'idx_product_filter');
            $table->index('category_id', 'idx_product_category_id');
            $table->index('brand_id', 'idx_product_brand_id');
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
