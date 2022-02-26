<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::get('search', [\App\Http\Controllers\ShopController::class, 'search'])->name('search');
Route::get('shop/{slug?}', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('shop/tag/{slug}', [\App\Http\Controllers\ShopController::class, 'tag'])->name('shop.tag');
Route::get('product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

Route::resource('cart', \App\Http\Controllers\CartController::class)->only(['index','store','update', 'destroy']);

Route::group(['middleware' => 'auth'], function() {

    Route::get('orders/checkout', [\App\Http\Controllers\OrderController::class, 'process'])->name('checkout.process');
    Route::get('orders/cities', [\App\Http\Controllers\OrderController::class, 'cities']);
    Route::post('orders/shipping-cost', [\App\Http\Controllers\OrderController::class, 'shippingCost']);
    Route::post('orders/set-shipping', [\App\Http\Controllers\OrderController::class, 'setShipping']);
    Route::post('orders/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');

    Route::group(['middleware' => 'isAdmin','prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);
        Route::post('/products/remove-image', [\App\Http\Controllers\Admin\ProductController::class, 'removeImage'])->name('products.removeImage');
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)->only(['index','edit','update','destroy','show']);
        Route::resource('slides', \App\Http\Controllers\Admin\SlideController::class);
        Route::get('slides/{slideId}/up', [\App\Http\Controllers\Admin\SlideController::class, 'moveUp']);
        Route::get('slides/{slideId}/down', [\App\Http\Controllers\Admin\SlideController::class, 'moveDown']);

        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index','show','destroy']);
        Route::get('orders/{orderId}/cancel', [\App\Http\Controllers\Admin\OrderController::class, 'cancel'])->name('orders.cancel');
        Route::put('orders/cancel/{orderId}', [\App\Http\Controllers\Admin\OrderController::class, 'cancelUpdate'])->name('orders.cancelUpdate');
        Route::post('orders/complete/{orderId}', [\App\Http\Controllers\Admin\OrderController::class, 'complete'])->name('orders.complete');
        Route::resource('shipments', \App\Http\Controllers\Admin\ShipmentController::class)->only(['index','edit','update']);

        Route::get('reports/revenue', [\App\Http\Controllers\Admin\ReportController::class, 'revenue'])->name('reports.revenue');
    });
});

Auth::routes();

