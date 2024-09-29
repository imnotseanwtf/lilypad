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
        Schema::create('xoitem', function (Blueprint $table) {
            $table->id(); 
            $table->datetime('dateLastFulfillment')->nullable();
            $table->datetime('dateScheduledFulfillment')->nullable();
            $table->string('description', 256)->nullable();
            $table->integer('lineItem');
            $table->longText('note')->nullable();
            $table->integer('partId')->nullable();
            $table->string('partNum', 70)->nullable();
            $table->decimal('qtyFulfilled', 28, 9)->nullable();
            $table->decimal('qtyPicked', 28, 9)->nullable();
            $table->decimal('qtyToFulfill', 28, 9)->nullable();
            $table->integer('revisionNum')->nullable();
            $table->integer('statusId');
            $table->decimal('totalCost', 28, 9)->nullable();
            $table->integer('typeId');
            $table->integer('uomId')->nullable();
            $table->integer('xoId');
            
            // Index for performance
            $table->index(['uomId', 'xoId', 'statusId', 'typeId', 'partId'], 'Performance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xoitem');
    }
};
