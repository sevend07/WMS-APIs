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
        Schema::create('warehouse_racks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique('warehouse_rack_name_unique');
            $table->foreignId('warehouse_zone_id')
                ->constrained('warehouse_zones')
                ->restrictOnDelete();
            $table->timestamps();

            $table->index('warehouse_zone_id', 'idx_rack_zone_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_racks');
    }
};
