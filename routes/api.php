<?php

use App\Http\Controllers\SalesOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('sales-order', SalesOrderController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
