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
        Schema::create('receiptitem', function (Blueprint $table) {
            $table->id();
            $table->boolean('billVendorFlag')->notNullable(); 
            $table->decimal('billedTotalCost', 28, 9)->nullable();
            $table->integer('carrierId')->nullable();
            $table->integer('customerId')->nullable();
            $table->dateTime('dateBilled')->nullable();
            $table->dateTime('dateLastModified')->nullable();
            $table->dateTime('dateReceived')->nullable();
            $table->dateTime('dateReconciled')->nullable();
            $table->string('deliverTo', 30)->nullable();
            $table->decimal('landedTotalCost', 28, 9)->nullable();
            $table->integer('locationId')->nullable();
            $table->integer('orderTypeId')->notNullable();
            $table->integer('packageCount')->nullable();
            $table->integer('partId')->nullable();
            $table->integer('partTypeId')->notNullable();
            $table->integer('poItemId')->nullable();
            $table->decimal('qty', 28, 9)->nullable();
            $table->string('reason', 90)->nullable();
            $table->integer('receiptId')->notNullable();
            $table->string('refNo', 20)->nullable();
            $table->integer('responsibilityId')->nullable();
            $table->integer('shipItemId')->nullable();
            $table->integer('soItemId')->nullable();
            $table->integer('statusId')->notNullable();
            $table->bigInteger('tagId')->nullable();
            $table->integer('taxId')->nullable();
            $table->double('taxRate')->nullable();
            $table->string('trackingNum', 30)->nullable();
            $table->integer('typeId')->notNullable();
            $table->integer('uomId')->notNullable();
            $table->integer('xoItemId')->nullable();

            // Create the index
            $table->index(['uomId', 'statusId', 'taxId', 'customerId', 'typeId', 'poItemId', 'carrierId', 'receiptId', 'partId', 'soItemId', 'orderTypeId', 'xoItemId', 'partTypeId', 'dateBilled', 'dateReceived', 'dateReconciled'], 'Performance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_items');
    }
};
