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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('state');
            $table->string('regency');
            $table->string('district');
            $table->string('postal_code');
            $table->string('address');
            $table->timestamps();

            $table->index('state', 'idx_location_state');
            $table->index('regency', 'idx_location_regency');
            $table->index('district', 'idx_location_district');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
