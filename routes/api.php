<?php

use App\Http\Controllers\Api\GoodsAttributesController;
use App\Http\Controllers\Api\GoodsController;
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

Route::get('goods', [GoodsController::class, 'index'])->name('goods');
Route::get('goods/{goods}', [GoodsController::class, 'show'])->name('goods.show');

Route::get('goods-attributes', [GoodsAttributesController::class, 'index'])->name('goods-attributes');
