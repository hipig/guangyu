<?php

namespace App\Admin\Controllers;

use App\Models\EvaluatorAttribute;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Cache;

class EvaluatorAttributesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '估价属性';

    protected $states = [
        'on'  => ['value' => 1, 'text' => '启用', 'color' => 'success'],
        'off' => ['value' => 2, 'text' => '禁用', 'color' => 'danger'],
    ];

    public function index(Content $content)
    {
        Permission::check('evaluator.attributes');
        return parent::index($content);
    }

    public function create(Content $content)
    {
        Permission::check('evaluator.attributes.create');
        return parent::create($content);
    }

    public function edit($id, Content $content)
    {
        Permission::check('evaluator.attributes.edit');
        return parent::edit($id, $content);
    }

    public function destroy($id)
    {
        Permission::check('evaluator.attributes.destroy');
        Cache::forget(EvaluatorAttribute::CACHE_KEY);
        return parent::destroy($id);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EvaluatorAttribute());

        $grid->column('key', '标识');
        $grid->column('label', '名称');
        $grid->column('type', '类型')->using(EvaluatorAttribute::$typeMap);
        $grid->column('is_compute', '是否参与计算')->using([1 => '是', 0 => '否']);
        $grid->column('rank', '排序')->editable();
        $grid->column('status', '状态')->switch($this->states);
        $grid->column('created_at', '创建时间');

        $grid->filter(function($filter) {
            $filter->equal('key', '标识');
            $filter->like('label', '名称');
            $filter->equal('type', '类型')->select(EvaluatorAttribute::$typeMap);
            $filter->equal('status', '状态')->radio(['' => '默认', 1 => '启用', 2 => '禁用']);
        });

        $grid->actions(function ($actions) {
            $actions->disableView();
            if (Admin::user()->cannot('evaluator.attributes.edit')) {
                $actions->disableEdit();
            }
            if (Admin::user()->cannot('evaluator.attributes.destroy')) {
                $actions->disableDelete();
            }
        });

        if (Admin::user()->cannot('evaluator.attributes.create')) {
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
        $form = new Form(new EvaluatorAttribute());

        $form->text('key', '标识')->rules('required');
        $form->text('label', '名称')->rules('required');
        $form->select('type', '类型')
            ->options(EvaluatorAttribute::$typeMap)
            ->when('in', EvaluatorAttribute::$needOptionTypeMap, function (Form $form) {
                $form->table('options', '属性选项', function ($table) {
                    $table->text('key', '选项标识');
                    $table->text('label', '选项名称');
                    $table->text('value', '选项价值')->default(0);
                });
            })->when('in', EvaluatorAttribute::TYPE_INPUT, function (Form $form) {
                $form->text('value', '属性价值');
            })->rules('required');

        $form->radio('is_compute', '参与计算')->default(1)->options([1 => '是', 0 => '否']);
        $form->number('rank', '排序')->default(0)->help('排序值越小越靠前');
        $form->switch('status', '状态')->default(1)->states($this->states);

        $form->submitted(function () {
            Cache::forget(EvaluatorAttribute::CACHE_KEY);
        });

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            if (Admin::user()->cannot('evaluator.attributes')) {
                $tools->disableList();
            }
            if (Admin::user()->cannot('evaluator.attributes.destroy')) {
                $tools->disableDelete();
            }
        });

        return $form;
    }
}
