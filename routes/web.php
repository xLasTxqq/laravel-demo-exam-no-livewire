<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RegisterController;
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

Route::get('/', [MainController::class, 'index'])->name('main');
Route::get('/count', [MainController::class, 'count'])->name('count');

Route::middleware('guest')->group(function () {
    Route::resource('login', LoginController::class);
    Route::resource('register', RegisterController::class);
});

Route::middleware('auth')->group(function () {
    Route::middleware('admin')->group(function () {
        Route::resource('category', CategoryController::class);
        Route::resource('application', ApplicationController::class)->only(['update']);
        Route::get('admin', [AdminController::class, 'index'])->name('admin');
    });
    Route::resource('application', ApplicationController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
