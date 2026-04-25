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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->string('size');
            $table->string('color');
            $table->decimal('price');

            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('size', 'idx_variant_size');
            $table->index('color', 'idx_variant_color');
            $table->index('product_id', 'idx_variant_product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
