<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\UserProductController;

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


Route::get('lang/{lang}', [LangController::class, 'changeLang'])->name('lang');

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->middleware('checkAdmin')->group(function () {
    Route::get('/index', [AdminController::class, 'index']);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserAdminController::class);
    Route::resource('orders', OrderAdminController::class);
});

Route::prefix('user')->name('users.')->group(function () {
    Route::resource('products', UserProductController::class);
    Route::get('productbycategory/{id}', [UserProductController::class, 'showByCategory'])->name('showbycategory');
    Route::get('search', [UserProductController::class, 'search'])->name('search');
    Route::prefix('cart')
    ->name('cart.')
    ->controller(CartController::class)
    ->middleware('auth')
    ->group(function () {
        Route::post('comment', [UserProductController::class, 'comment'])->name('comment');
        Route::get('/', 'cart')->name('showCart');
        Route::post('/addToCart', 'addToCart')->name('addToCart');
        Route::post('/update', 'updateCart')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::post('/payment', 'payment')->name('payment');
        Route::get('/complete/{id}', 'complete')->name('complete');
    });
});
