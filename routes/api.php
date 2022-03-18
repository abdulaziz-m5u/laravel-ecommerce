<?php

use Illuminate\Http\Request;
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


Route::post('register', [\App\Http\Controllers\API\UserController::class, 'register']);
Route::post('login', [\App\Http\Controllers\API\UserController::class, 'login']);


Route::middleware('auth:api', 'sessions')->group(function () {
    Route::get('profile', [\App\Http\Controllers\API\UserController::class, 'getProfile']);
    Route::get('logout', [\App\Http\Controllers\API\UserController::class, 'logout']);

    Route::get('cart', [\App\Http\Controllers\API\CartController::class, 'index']);
    Route::post('cart', [\App\Http\Controllers\API\CartController::class, 'store']);
    Route::put('cart/{cart_id}', [\App\Http\Controllers\API\CartController::class, 'update']);
    Route::delete('cart/{cart_id}', [\App\Http\Controllers\API\CartController::class, 'destroy']);
    Route::delete('cart', [\App\Http\Controllers\API\CartController::class, 'clear']);

    Route::get('cart/shipping-options', [\App\Http\Controllers\API\CartController::class, 'shippingOptions']);
    Route::post('cart/set-shipping', [\App\Http\Controllers\API\CartController::class, 'setShipping']);

    Route::post('order/checkout', [\App\Http\Controllers\API\OrderController::class, 'checkout']);
});

Route::middleware('client')->group(function () {
    Route::get('product', [\App\Http\Controllers\API\ProductController::class, 'index']);
    Route::get('product/{slug}', [\App\Http\Controllers\API\ProductController::class, 'show']);
});




