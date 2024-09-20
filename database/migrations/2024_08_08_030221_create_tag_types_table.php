<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tagtype', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('tagtype')->insert(
            [
                ['id' => 30, 'name' => 'Child'],
                ['id' => 10, 'name' => 'Location'],
                ['id' => 20, 'name' => 'Parent'],
                ['id' => 40, 'name' => 'Virtual'],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_types');
    }
};
