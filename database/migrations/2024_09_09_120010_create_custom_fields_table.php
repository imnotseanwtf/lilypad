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
        Schema::create('customfield', function (Blueprint $table) {
            $table->id();
            $table->boolean('accessRight');
            $table->boolean('activeFlag');
            $table->unsignedInteger('customFieldTypeId');
            $table->string('description', 256)->nullable();
            $table->unsignedInteger('listId')->nullable();
            $table->string('name', 41)->unique();
            $table->boolean('required');
            $table->unsignedInteger('sortOrder');
            $table->unsignedInteger('tableId')->unique();
            
            $table->index(['listId', 'tableId', 'customFieldTypeId'], 'Performance');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_fields');
    }
};
