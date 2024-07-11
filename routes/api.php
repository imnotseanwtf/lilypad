<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResources(
    [
        'sales-order' => SalesOrderController::class,
        'product' => ProductController::class,
    ]
);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
