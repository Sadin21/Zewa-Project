<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CostumerPage\HomeController;
use App\Http\Controllers\CostumerPage\ProfileController;
use App\Http\Controllers\CostumerPage\ProductController;
use App\Http\Controllers\CostumerPage\CartController;
use App\Http\Controllers\CostumerPage\TransactionController;
use App\Http\Controllers\Dashboard\ManageUserController;
use App\Http\Controllers\Dashboard\ManageProductController;
use App\Http\Controllers\Dashboard\ManageTransactionController;
use App\Http\Controllers\Dashboard\ManageProductCategoryController;


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
    return redirect(route('home.index'));
});

Route::controller(AuthController::class)->name('auth.')->prefix('auth')->group(function () {
    Route::match(['get', 'post'], 'login', 'authenticate')->name('login');
    Route::match(['get', 'post'], 'signup', 'signup')->name('signup');
    Route::post('logout', 'logout')->name('logout');
});

Route::controller(HomeController::class)->name('home.')->prefix('home')->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::controller(ProductController::class)->name('product.')->prefix('product')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/detail/{id}', 'getDetailData')->name('getDetailData');
});

Route::controller(CartController::class)->name('cart.')->prefix('cart')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('store', 'store')->name('store');
});

Route::controller(TransactionController::class)->name('transaction.')->prefix('transaction')->group(function () {
    Route::post('/checkout', 'process')->name('checkout');
    Route::get('/success', 'updatePaymentStatus')->name('success');
    Route::get('/index', 'index')->name('index');
});

Route::controller(ProfileController::class)->name('profile.')->prefix('profile')->group(function () {
    Route::match(['get', 'post'], 'update', 'updateProfile')->name('update');
});

Route::controller(InvoiceController::class)->name('invoice.')->prefix('invoice')->group(function () {
    Route::get('/download-invoice', 'downloadInvoice')->name('downloadInvoice');
});


Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return redirect(route('dashboard.manage-user.index'));
    });

    Route::controller(ManageUserController::class)->name('manage-user.')->prefix('manage-user')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::match(['get', 'post'], 'create', 'create')->name('create');
        Route::match(['get', 'post'], '{id}', 'update')->name('update');
    });

    Route::controller(ManageProductController::class)->name('manage-product.')->prefix('manage-product')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::match(['get', 'post'], 'create', 'create')->name('create');
        Route::match(['get', 'post'], '{id}', 'update')->name('update');
    });

    Route::controller(ManageTransactionController::class)->name('manage-transaction.')->prefix('manage-transaction')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(ManageProductCategoryController::class)->name('manage-product-category.')->prefix('manage-product-category')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::match(['get', 'post'], 'create', 'create')->name('create');
        Route::match(['get', 'post'], '{id}', 'update')->name('update');
    });
});
