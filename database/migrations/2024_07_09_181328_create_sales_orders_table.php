<?php

use App\Models\AccountType;
use App\Models\Carrier;
use App\Models\CarrierService;
use App\Models\Country;
use App\Models\Customer;
use App\Models\State;
use App\Models\Tax;
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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customerName');
            $table->string('customerContact');
            $table->string('billToAddress');
            $table->string('billToCity');
            $table->string('billToName');
            $table->string('billToZip');
            $table->date('dateFirstShip');
            $table->string('shipToAddress');
            $table->string('shipToCity');
            $table->string('shipToName');
            $table->string('shipToZip');
            $table->foreignIdFor(Tax::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Country::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(State::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(AccountType::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Customer::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Carrier::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(CarrierService::class)->constrained()->cascadeOnDelete();
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
