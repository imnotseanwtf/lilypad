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
        Schema::create('receipt', function (Blueprint $table) {
            $table->id(); 
            $table->integer('locationGroupId')->notNullable();
            $table->integer('orderTypeId')->notNullable();
            $table->integer('poId')->nullable();
            $table->integer('soId')->nullable();
            $table->integer('statusId')->notNullable();
            $table->integer('typeId')->notNullable();
            $table->integer('userId')->notNullable();
            $table->integer('xoId')->nullable();

            // Create the index1
            $table->index(['xoId', 'locationGroupId', 'typeId', 'orderTypeId', 'soId', 'statusId', 'userId', 'poId'], 'Performance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
