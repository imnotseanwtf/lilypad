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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->boolean('active_flag');
            $table->unsignedBigInteger('location_group_id');
            $table->text('description');
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('pickable');
            $table->boolean('receivable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
