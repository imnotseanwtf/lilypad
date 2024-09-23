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
        Schema::create('uomconversion', function (Blueprint $table) {
            $table->id();
            $table->string('description', 256);
            $table->double('factor')->nullable();
            $table->unsignedBigInteger('fromUomId')->unique()->nullable();
            $table->double('multiply')->nullable();
            $table->unsignedBigInteger('toUomId')->unique()->nullable();
            $table->index('fromUomId', 'Performance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uomconversion');
    }
};
