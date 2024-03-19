<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CostumerPage\HomeController;
use App\Http\Controllers\CostumerPage\ProfileController;
use App\Http\Controllers\CostumerPage\ProductController;
use App\Http\Controllers\Dashboard\ManageUserController;
use App\Http\Controllers\Dashboard\ManageProductController;


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

// Route::get('/auth/signin', function () {
//     return view('pages.auth.index');
// });

Route::controller(AuthController::class)->name('auth.')->prefix('auth')->group(function () {
    Route::match(['get', 'post'], 'login', 'authenticate')->name('login');
    Route::match(['get', 'post'], 'signup', 'signup')->name('signup');
    Route::post('logout', 'logout')->name('logout');
});

Route::controller(HomeController::class)->name('home.')->prefix('home')->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::controller(ProductController::class)->name('product.')->prefix('product')->group(function () {
    Route::get('/', 'getAllData')->name('getAllData');
    Route::get('/detail/{id}', 'getDetailData')->name('getDetailData');
});

Route::controller(ProfileController::class)->name('profile.')->prefix('profile')->group(function () {
    Route::match(['get', 'post'], 'update', 'updateProfile')->name('update');
});


Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', function () {
        return redirect(route('dashboard.manage-user.index'));
    });

    Route::controller(ManageUserController::class)->name('manage-user.')->prefix('manage-user')->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::controller(ManageProductController::class)->name('manage-product.')->prefix('manage-product')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::match(['get', 'post'], 'create', 'create')->name('create');
        Route::match(['get', 'post'], '{id}', 'update')->name('update');
    });
});
