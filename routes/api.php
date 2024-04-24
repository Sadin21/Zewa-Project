<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ManageProductController;
use App\Http\Controllers\Dashboard\ManageTransactionController;
use App\Http\Controllers\CostumerPage\ProductCategoryController;
use App\Http\Controllers\CostumerPage\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ProductCategoryController::class)->name('product-category.')->prefix('product-category')->group(function () {
    Route::get('/', 'getAllData')->name('getAllData');
});

Route::controller(ProductController::class)->name('api.product.')->prefix('product')->group(function () {
    Route::get('/', 'getAllData')->name('getAllData');
    Route::get('/name', 'getDataByName')->name('getDataByName');
});

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::controller(ManageProductController::class)->name('product.')->prefix('product')->group(function () {
        Route::get('/', 'getAllData')->name('getAllData');
        Route::delete('delete/{id}', 'destroy')->name('delete');
    });

    Route::controller(ManageTransactionController::class)->name('manage-transaction.')->prefix('manage-transaction')->group(function () {
        Route::get('/', 'getAllData')->name('getAllData');
    });
});
