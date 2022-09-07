<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('goods', [\App\Http\Controllers\REST\GoodController::class, 'index'])->name('goods');
Route::get('goods/{good}', [\App\Http\Controllers\REST\GoodController::class, 'edit'])->name('good');
Route::get('categories', [\App\Http\Controllers\REST\CategoryController::class, 'index'])->name('categories');

Route::delete('goods/{good}', [\App\Http\Controllers\REST\GoodController::class, 'destroy'])->name('goods.delete');
Route::put('goods/{good}', [\App\Http\Controllers\REST\GoodController::class, 'update'])->name('goods.update');
Route::post('goods', [\App\Http\Controllers\REST\GoodController::class, 'store'])->name('goods.create');

Route::delete('categories/{category}', [\App\Http\Controllers\REST\CategoryController::class, 'destroy'])->name('categories.delete');
Route::post('categories', [\App\Http\Controllers\REST\CategoryController::class, 'store'])->name('categories.create');
