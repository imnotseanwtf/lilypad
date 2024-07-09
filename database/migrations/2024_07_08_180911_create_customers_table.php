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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->boolean('active_flag');
            $table->unsignedBigInteger('default_payment_terms_id');
            $table->string('name');
            $table->string('number');
            $table->unsignedBigInteger('status_id');
            $table->boolean('tax_exempt');
            $table->boolean('to_be_emailed');
            $table->boolean('to_be_printed');
            $table->string('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
