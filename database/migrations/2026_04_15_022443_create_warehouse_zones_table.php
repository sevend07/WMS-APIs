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
        Schema::create('warehouse_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique('warehouse_zone_name_unique');
            $table->foreignId('warehouse_id')
            ->constrained('warehouses')
            ->restrictOnDelete();
            $table->timestamps();

            $table->index('warehouse_id', 'idx_zone_warehouse_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_zones');
    }
};
