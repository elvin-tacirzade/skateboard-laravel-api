<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


//Products
Route::get('products', [ProductController::class, 'products']);
//Add product
Route::post('add-product', [ProductController::class, 'add_product']);
//Orders
Route::get('orders', [OrderController::class, 'orders']);
//Orders update
Route::put('order-update', [OrderController::class, 'order_update']);

Route::fallback(function () {
    return response()->json(array("error" => ["Page not found"]), 404);
});
