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
        Schema::create('poitem', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customerId')->nullable();
            $table->dateTime('dateLastFulfillment')->nullable();
            $table->dateTime('dateScheduledFulfillment')->nullable();
            $table->string('description', 256)->nullable();
            $table->longText('note')->nullable();
            $table->unsignedBigInteger('partId')->nullable();
            $table->string('partNum', 70)->nullable();
            $table->unsignedBigInteger('poId');
            $table->unsignedInteger('poLineItem');
            $table->unsignedBigInteger('qbClassId')->nullable();
            $table->decimal('qtyFulfilled', 28, 9)->nullable();
            $table->decimal('qtyPicked', 28, 9)->nullable();
            $table->decimal('qtyToFulfill', 28, 9)->nullable();
            $table->boolean('repairFlag')->default(false);
            $table->string('revLevel', 15)->nullable();
            $table->unsignedBigInteger('statusId');
            $table->unsignedBigInteger('taxId')->nullable();
            $table->double('taxRate')->nullable();
            $table->boolean('tbdCostFlag')->default(false);
            $table->decimal('totalCost', 28, 9)->nullable();
            $table->unsignedBigInteger('typeId');
            $table->decimal('unitCost', 28, 9)->nullable();
            $table->unsignedBigInteger('uomId')->nullable();
            $table->string('vendorPartNum', 70)->nullable();
            $table->string('customFields')->nullable();

            $table->index(['customerId', 'poId', 'partId', 'taxId', 'typeId', 'statusId', 'qbClassId'], 'Performance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poitem');
    }
};
