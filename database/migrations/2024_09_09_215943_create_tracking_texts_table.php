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
        Schema::create('trackingtext', function (Blueprint $table) {
            $table->id();
            $table->string('info', 41)->nullable();
            $table->unsignedInteger('partTrackingId')->nullable();
            $table->unsignedBigInteger('tagId');
            
            $table->index(['partTrackingId', 'tagId'], 'Performance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_texts');
    }
};
