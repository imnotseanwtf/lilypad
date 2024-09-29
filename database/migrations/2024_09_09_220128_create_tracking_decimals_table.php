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
        Schema::create('trackingdecimal', function (Blueprint $table) {
            $table->id();
            $table->double('info')->nullable();
            $table->unsignedInteger('partTrackingId');
            $table->unsignedBigInteger('tagId');
            
            $table->index(['partTrackingId', 'tagId'], 'Performance');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_decimals');
    }
};
