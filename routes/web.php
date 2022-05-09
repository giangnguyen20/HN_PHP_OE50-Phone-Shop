<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserAdminController;
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
    Route::resource('categories', CategoriesController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserAdminController::class);
});

Route::prefix('user')->name('users.')->group(function () {
    Route::resource('products', UserProductController::class);
    Route::get('productbycategory/{id}', [UserProductController::class, 'showByCategory'])->name('category');
});
