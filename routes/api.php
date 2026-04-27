<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class);
Route::delete('/products/{id}/hard-delete', [ProductController::class, 'hardDelete']);


Route::get('test', [ProductController::class, 'test']);