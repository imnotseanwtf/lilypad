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
        Schema::create('paymentmethod', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->boolean('editable');
            $table->string('name', 30)->nullable()->unique();
            $table->unsignedInteger('typeId');
        
            $table->index('typeId', 'Performance');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
