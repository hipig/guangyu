<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use App\Admin\Extensions\BelongsToMany;
use Encore\Admin\Grid;
use \Encore\Admin\Form;

Encore\Admin\Form::forget(['map', 'editor']);

app('view')->prependNamespace('admin', resource_path('views/admin'));

Grid::init(function (Grid $grid) {

    $grid->filter(function($filter){
        $filter->disableIdFilter();
    });

    $grid->actions(function (Grid\Displayers\Actions $actions) {
        $actions->disableView();
    });
});

Form::init(function (Form $form) {

    $form->disableViewCheck();

    $form->tools(function (Form\Tools $tools) {
        $tools->disableView();
    });
});

Form::extend('belongsToMany', BelongsToMany::class);
