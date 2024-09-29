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
        Schema::create('postransaction', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 28, 9)->nullable();
            $table->string('authCode', 20)->nullable();
            $table->decimal('changeGiven', 28, 9)->nullable();
            $table->string('confirmation', 30)->nullable();
            $table->double('currencyRate')->nullable();
            $table->dateTime('dateTime')->nullable();
            $table->unsignedInteger('depositToAccountId')->nullable();
            $table->dateTime('expDate')->nullable();
            $table->string('merchantActNum', 20)->nullable();
            $table->longText('miscCreditCard')->nullable();
            $table->unsignedInteger('paymentMethodIdid'); // Assuming this should be paymentMethodIdid, based on your structure
            $table->string('reference', 100)->nullable();
            $table->unsignedInteger('soId')->nullable();
            $table->string('transactionId', 20)->nullable();
            $table->unsignedInteger('userId')->nullable();
            $table->unsignedInteger('paymentMethodId')->nullable();
            
            $table->index(['userId', 'soId', 'depositToAccountId', 'paymentMethodId'], 'Performance');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_transactions');
    }
};
