<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class);
Route::delete('/products/{id}/hard-delete', [ProductController::class, 'hardDelete']);

Route::apiResource('categories', CategoryController::class);
Route::post('/categories/bulk-store', [CategoryController::class, 'bulkStore']);

Route::apiResource('brands', BrandController::class);
Route::post('/brands/bulk-store', [BrandController::class, 'bulkStore']);

Route::get('test', [ProductController::class, 'test']);