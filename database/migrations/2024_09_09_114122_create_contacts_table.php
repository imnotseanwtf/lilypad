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
        Schema::create('contact', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('accountId');
            $table->unsignedInteger('addressId')->nullable();
            $table->string('datus', 64)->nullable();
            $table->boolean('defaultFlag')->nullable();
            $table->string('contactName', 30)->nullable();
            $table->unsignedInteger('typeId');
            
            $table->index(['accountId', 'typeId', 'addressId'], 'Performance');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
