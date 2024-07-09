<?php

use App\Models\Carrier;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carrier_services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Carrier::class)->constrained()->cascadeOnDelete();
            // $table->boolean('active_flag');
            $table->string('code');
            $table->string('name');
            // $table->boolean('read_only');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrier_services');
    }
};
