<?php

use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo2', [DemoController::class, 'index2']);
Route::get('/demo3', [DemoController::class, 'index3']);
Route::get('/demo4/{id}', [DemoController::class, 'index4']);
Route::get('/demo5/{id}', [DemoController::class, 'index5']);
Route::get('/demo6/{id}', [DemoController::class, 'index6']);



Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/brands', BrandController::class);
    Route::resource('/admin/products', ProductController::class);
    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/posts', PostController::class);
});


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.home');

Route::get('test1', [ProductController::class, 'test1']);
Route::get('test2', [ProductController::class, 'test2']);
