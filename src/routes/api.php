<?php

use App\Http\Controllers\APIs\AddressController;
use App\Http\Controllers\APIs\AuthController;
use App\Http\Controllers\APIs\CartController;
use App\Http\Controllers\APIs\OrderController;
use App\Http\Controllers\APIs\ProductController;
use App\Http\Controllers\APIs\ProfileController;
use App\Http\Controllers\APIs\ProvinceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('products', ProductController::class);
Route::apiResource('provinces', ProvinceController::class);
Route::apiResource('large-categories', LargeCategoryController::class);
Route::apiResource('large-categories.small-categories', SmallCategoryController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('cart', CartController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('addresses', AddressController::class);
    Route::apiResource('profile', ProfileController::class);
});
