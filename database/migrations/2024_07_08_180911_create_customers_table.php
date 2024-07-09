<?php

use App\Models\CustomerStatus;
use App\Models\PaymentTerms;
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
            // $table->boolean('activeFlag');
            $table->foreignIdFor(PaymentTerms::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('number');
            $table->foreignIdFor(CustomerStatus::class)->constrained()->cascadeOnDelete();
            $table->boolean('taxExempt');
            $table->boolean('toBeEmailed');
            $table->boolean('toBePrinted');
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
