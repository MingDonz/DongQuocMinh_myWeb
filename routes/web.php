<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Client\CartController;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}', [ClientProductController::class, 'category'])->name('products.category');
Route::get('/brand/{slug}', [ClientProductController::class, 'brand'])->name('products.brand');
Route::get('/product/{slug}', [ClientProductController::class, 'show'])->name('product.show');
Route::get('/search', [ClientProductController::class, 'search'])->name('products.search');


Route::prefix('cart')->controller(CartController::class)->name('cart.')->group(function () {
    Route::get('/show', 'show')->name('show');
    Route::post('/add/{id}', 'addToCart')->name('add');
    Route::delete('/remove/{id}', 'removeCart')->name('remove');

    Route::post('/checkout', 'checkout')->name('checkout');
});

Route::get('/test', function () {
    return "Test";
});


Route::get('/demo', [DemoController::class, 'index']);
Route::get('/demo2', [DemoController::class, 'index2']);
Route::get('/demo3', [DemoController::class, 'index3']);
Route::get('/demo4/{id}', [DemoController::class, 'index4']);
Route::get('/demo5/{id?}', [DemoController::class, 'index5']);
Route::get('/demo6/{parram1}/{parram2}', [DemoController::class, 'index6']);



//Buoi2 Lab3 tiep theo bo sung

//Lab 4
Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.home');

Route::get('/test1', [ProductController::class, 'test1']);
Route::get('/test2', [ProductController::class, 'test2']);

// Route::prefix('admin')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.home');
// });

Route::prefix('admin')->name('admin.')->group(function () {

    // Authentication
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'postLogin'])
        ->name('login.post');


    Route::get('/forgotpass', [AuthController::class, 'forgotPassword'])
        ->name('forgotpass');

    Route::post('/forgotpass', [AuthController::class, 'postforgotPassword'])
        ->name('forgotpass.post');

    Route::middleware('auth')->group(function () {

        Route::get('/change-password', [AuthController::class, 'changePassword'])
            ->name('change-password');

        Route::post('/change-password', [AuthController::class, 'postChangePassword'])
            ->name('change-password.post');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        Route::middleware('roles:1')->group(
            function () {

                // Hiển thị danh sách dữ liệu đã xóa mềm Soft Delete (Thùng rác)
                Route::get('trash/categories', [CategoryController::class, 'trash'])
                    ->name('categories.trash');


                // Khôi phục
                Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])
                    ->name('categories.restore');
                // Xóa vĩnh viễn
                Route::delete('categories/{id}/forcedelete', [CategoryController::class, 'forceDelete'])
                    ->name('categories.forceDelete');

                Route::get('trash/categories', [CategoryController::class, 'trash'])->name('categories.trash');
                Route::patch('categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
                Route::delete('categories/{id}/forcedelete', [CategoryController::class, 'forceDelete'])->name('categories.forceDelete');
                Route::patch('categories/restore-all', [CategoryController::class, 'restoreAll'])->name('categories.restoreAll');
                Route::delete('categories/force-delete-all', [CategoryController::class, 'forceDeleteAll'])->name('categories.forceDeleteAll');

                Route::get('trash/brands', [BrandController::class, 'trash'])->name('brands.trash');
                Route::patch('brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
                Route::delete('brands/{id}/forcedelete', [BrandController::class, 'forceDelete'])->name('brands.forceDelete');
                Route::patch('brands/restore-all', [BrandController::class, 'restoreAll'])->name('brands.restoreAll');
                Route::delete('brands/force-delete-all', [BrandController::class, 'forceDeleteAll'])->name('brands.forceDeleteAll');

                Route::get('trash/users', [UserController::class, 'trash'])->name('users.trash');
                Route::patch('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
                Route::delete('users/{id}/forcedelete', [UserController::class, 'forceDelete'])->name('users.forceDelete');
                Route::patch('users/restore-all', [UserController::class, 'restoreAll'])->name('users.restoreAll');
                Route::delete('users/force-delete-all', [UserController::class, 'forceDeleteAll'])->name('users.forceDeleteAll');

                Route::get('trash/products', [ProductController::class, 'trash'])->name('products.trash');
                Route::patch('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
                Route::delete('products/{id}/forcedelete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
                Route::patch('products/restore-all', [ProductController::class, 'restoreAll'])->name('products.restoreAll');
                Route::delete('products/force-delete-all', [ProductController::class, 'forceDeleteAll'])->name('products.forceDeleteAll');
                Route::delete('products/{product}/images/{image}', [ProductController::class, 'deleteImage']);

                Route::get('trash/posts', [PostController::class, 'trash'])->name('posts.trash');
                Route::patch('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');
                Route::delete('posts/{id}/forcedelete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');
                Route::patch('posts/restore-all', [PostController::class, 'restoreAll'])->name('posts.restoreAll');
                Route::delete('posts/force-delete-all', [PostController::class, 'forceDeleteAll'])->name('posts.forceDeleteAll');

                Route::resource('categories', CategoryController::class);
                Route::resource('brands', BrandController::class);
                Route::resource('users', UserController::class);
                Route::resource('products', ProductController::class);
                Route::resource('posts', PostController::class);
                
                Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
                Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
                Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
            
            }
        );
        Route::resource('products', ProductController::class)
            ->only(['index'])->middleware('roles:1,2');
    });
});

Route::get('/test-500', function () {
    abort(500);
});
