<?php

use App\Http\Controllers\V1\CustomerController;
use App\Http\Controllers\V1\PartController;
use App\Http\Controllers\V1\ProductController;
use App\Http\Controllers\V1\SalesOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    'sales-order' => SalesOrderController::class,
    'product' => ProductController::class,
    'customer' => CustomerController::class,
    'part' => PartController::class,
]);

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    
});