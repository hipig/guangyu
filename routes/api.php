<?php

use App\Http\Controllers\Api;
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

Route::get('goods', [Api\GoodsController::class, 'index'])->name('goods');
Route::get('goods/{goods}', [Api\GoodsController::class, 'show'])->name('goods.show');

Route::get('goods-attributes', [Api\GoodsAttributesController::class, 'index'])->name('goods-attributes');

Route::get('evaluator-attributes', [Api\EvaluatorAttributesController::class, 'index'])->name('evaluator-attributes');
Route::post('evaluator-records', [Api\EvaluatorRecordsController::class, 'store'])->name('evaluator-records.store');
