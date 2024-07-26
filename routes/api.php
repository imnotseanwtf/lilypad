<?php

use App\Http\Controllers\V1\CustomerController;
use App\Http\Controllers\V1\PartController;
use App\Http\Controllers\V1\ProductController;
use App\Http\Controllers\V1\SalesOrderController;
use App\Http\Controllers\V1\SalesOrderItemController;
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
    'so-item' => SalesOrderItemController::class,
]);

Route::prefix('v1')->middleware('auth:api')->group(function () {
   
});
