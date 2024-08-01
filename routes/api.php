<?php

use App\Http\Controllers\V1\CountryAndStateController;
use App\Http\Controllers\V1\CurrencyController;
use App\Http\Controllers\V1\CustomerController;
use App\Http\Controllers\V1\PartController;
use App\Http\Controllers\V1\PaymentTermsController;
use App\Http\Controllers\V1\ProductController;
use App\Http\Controllers\V1\QuickBookClassController;
use App\Http\Controllers\V1\SalesOrderController;
use App\Http\Controllers\V1\TaxRateController;
use App\Http\Controllers\V1\UnitOfMeasureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'sales-order' => SalesOrderController::class,   
    'product' => ProductController::class,
    'customer' => CustomerController::class,
    'part' => PartController::class,
    'country-state' => CountryAndStateController::class,
    'qbclass' => QuickBookClassController::class,
    'taxrate' => TaxRateController::class,
    'currency' => CurrencyController::class,
    'uom' => UnitOfMeasureController::class,
    'payment-terms' => PaymentTermsController::class,
]);

Route::prefix('v1')->middleware('auth:api')->group(function () {
   
});
