<?php

use App\Models\AccountType;
use App\Models\State;
use App\Models\Country;
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
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accountId')->nullable();
            $table->string('name', 41);
            $table->string('city', 30)->nullable();
            $table->boolean('defaultFlag')->default(true);
            $table->string('addressName', 90)->nullable()->unique();
            $table->integer('pipelineContactNum')->nullable();
            $table->string('address', 90);
            $table->string('zip', 10)->nullable();

            $table->foreignId('countryId')->constrained('country')->nullable();
            $table->foreignId('typeID')->constrained('addresstype')->nullable();
            $table->foreignId('stateId')->constrained('state')->nullable();
            $table->foreignId('locationGroupId')->constrained('locationgroup')->nullable();

            $table->index(['accountId', 'locationGroupId', 'stateId', 'typeID', 'countryId'], 'Performance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
