<?php

use App\Admin\Controllers;
use App\Admin\Forms;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
//    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', [Controllers\HomeController::class, 'index'])->name('home');
    $router->get('settings', Forms\Setting::class)->name('settings');
    $router->resource('goods-attributes', Controllers\GoodsAttributesController::class)->names('goods-attributes');
    $router->resource('goods', Controllers\GoodsController::class)->names('goods');

    $router->get('store', [Controllers\StoreController::class, 'index'])->name('store');

});
