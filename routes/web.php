<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Dashboard', []);
})->name('/');

Route::get('categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories');

Route::get('goods', [\App\Http\Controllers\GoodController::class, 'index'])->name('goods');
Route::get('goods/create', [\App\Http\Controllers\GoodController::class, 'create'])->name('goods.create');
Route::get('goods/edit/{good}', [\App\Http\Controllers\GoodController::class, 'edit'])->name('goods.edit');
