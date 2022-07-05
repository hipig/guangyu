<?php

namespace App\Admin\Controllers;

use App\Models\GoodsAttribute;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Cache;

class GoodsAttributesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品属性';

    protected $states = [
        'on'  => ['value' => 1, 'text' => '启用', 'color' => 'success'],
        'off' => ['value' => 2, 'text' => '禁用', 'color' => 'danger'],
    ];

    public function index(Content $content)
    {
        Permission::check('goods.attributes');
        return parent::index($content);
    }

    public function create(Content $content)
    {
        Permission::check('goods.attributes.create');
        return parent::create($content);
    }

    public function edit($id, Content $content)
    {
        Permission::check('goods.attributes.edit');
        return parent::edit($id, $content);
    }

    public function destroy($id)
    {
        Permission::check('goods.attributes.destroy');
        Cache::forget(GoodsAttribute::CACHE_KEY);
        return parent::destroy($id);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GoodsAttribute());
        $grid->model()->orderBy('status')->latest();
        $grid->column('type', '属性类型')->using(GoodsAttribute::$typeMap);
        $grid->column('value', '属性值');
        $grid->column('rank', '排序')->editable();
        $grid->column('status', '状态')->switch($this->states);
        $grid->column('created_by', '创建人');
        $grid->column('created_at', '创建时间');

        $grid->filter(function($filter) {
            $filter->equal('type', '属性类型')->select(GoodsAttribute::$typeMap);
            $filter->like('value', '属性值');
            $filter->equal('status', '状态')->radio(['' => '默认', 1 => '启用', 2 => '禁用']);
        });

        $grid->actions(function ($actions) {
            $actions->disableView();
            if (Admin::user()->cannot('goods.attributes.edit')) {
                $actions->disableEdit();
            }
            if (Admin::user()->cannot('goods.attributes.destroy')) {
                $actions->disableDelete();
            }
        });

        if (Admin::user()->cannot('goods.attributes.create')) {
            $grid->disableCreateButton();
        }

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new GoodsAttribute());
        $form->select('type', '属性类型')->options(GoodsAttribute::$typeMap)->rules('required');
        $form->text('value', '属性值')->rules('required');
        $form->number('rank', '排序')->default(0)->help('排序值越小越靠前');
        $form->switch('status', '状态')->default(1)->states($this->states);

        $form->submitted(function () {
           Cache::forget(GoodsAttribute::CACHE_KEY);
        });

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            if (Admin::user()->cannot('goods.attributes')) {
                $tools->disableList();
            }
            if (Admin::user()->cannot('goods.attributes.destroy')) {
                $tools->disableDelete();
            }
        });

        return $form;
    }
}
