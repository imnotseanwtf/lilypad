<?php

use App\Http\Controllers\V1\CountryAndStateController;
use App\Http\Controllers\V1\CurrencyController;
use App\Http\Controllers\V1\CustomerController;
use App\Http\Controllers\V1\InventoryLogController;
use App\Http\Controllers\V1\LocationController;
use App\Http\Controllers\V1\PartController;
use App\Http\Controllers\V1\PaymentTermsController;
use App\Http\Controllers\V1\PickController;
use App\Http\Controllers\V1\ProductController;
use App\Http\Controllers\V1\QuickBookClassController;
use App\Http\Controllers\V1\SalesOrderController;
use App\Http\Controllers\V1\TaxRateController;
use App\Http\Controllers\V1\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'pick' => PickController::class,
    'sales-order' => SalesOrderController::class,
    'product' => ProductController::class,
    'customer' => CustomerController::class,
    'location' => LocationController::class,
    'inventory' => InventoryLogController::class,
    'part' => PartController::class,
    'vendor' => VendorController::class,
    'country-state' => CountryAndStateController::class,
    'qbclass' => QuickBookClassController::class,
    'taxrate' => TaxRateController::class,
    'currency' => CurrencyController::class,
    'payment-terms' => PaymentTermsController::class,
]);

Route::prefix('v1')->middleware('auth:api')->group(function () {});
