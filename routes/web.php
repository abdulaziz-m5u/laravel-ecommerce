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

Route::get('/', function () {
    return view('frontend.homepage');
});

Route::get('search', [\App\Http\Controllers\ShopController::class, 'search'])->name('search');
Route::get('shop/{slug?}', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('shop/tag/{slug}', [\App\Http\Controllers\ShopController::class, 'tag'])->name('shop.tag');
Route::get('product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.show');

Route::resource('cart', \App\Http\Controllers\CartController::class)->only(['index','store','update', 'destroy']);

Route::group(['middleware' => 'isAdmin','prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('tags', \App\Http\Controllers\Admin\TagController::class);
    Route::post('/products/remove-image', [\App\Http\Controllers\Admin\ProductController::class, 'removeImage'])->name('products.removeImage');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('slides', \App\Http\Controllers\Admin\SlideController::class);
    Route::get('slides/{slideID}/up', [\App\Http\Controllers\Admin\SlideController::class, 'moveUp']);
    Route::get('slides/{slideID}/down', [\App\Http\Controllers\Admin\SlideController::class, 'moveDown']);
});

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home');
