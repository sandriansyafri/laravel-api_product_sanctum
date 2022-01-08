<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('v1/register', [AuthController::class, 'register']);
Route::post('v1/login', [AuthController::class, 'login']);

Route::get('v1/product', [ProductController::class, 'index']);
Route::get('v1/product/search/{keywords}', [ProductController::class, 'search']);
Route::get('v1/product/{product}', [ProductController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function () {
      Route::post('v1/logout', [AuthController::class, 'logout']);
      Route::post('v1/product', [ProductController::class, 'store']);
      Route::put('v1/product/{product}', [ProductController::class, 'update']);
      Route::delete('v1/product/{product}', [ProductController::class, 'destroy']);
});



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
