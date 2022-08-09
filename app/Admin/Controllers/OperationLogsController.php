<?php

namespace App\Admin\Controllers;

use App\Models\OperationLog;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Arr;

class OperationLogsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '操作日志';

    public function index(Content $content)
    {
        Permission::check('operation-logs');
        return parent::index($content);
    }

    public function destroy($id)
    {
        Permission::check('operation-logs.destroy');
        return parent::destroy($id);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OperationLog());

        $grid->column('relation_type', '关联类型')->using(OperationLog::$relationTypeMaps);
        $grid->column('relation_url', '关联名称')->display(function () {
            return "<a href='{$this->relation_url}' target='_blank'>{$this->relation_name}</a>";
        });
        $grid->column('operation_type', '操作类型')->using(OperationLog::$operationTypeMaps);
        $grid->column('operation_by', '操作人');
        $grid->column('created_at', '操作时间');

        $grid->filter(function($filter) {
            $filter->like('relation_name', '关联名称');
            $filter->equal('account_type', '操作类型')->select(OperationLog::$operationTypeMaps);
        });

        $grid->disableCreateButton();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit();
        });

        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new OperationLog());

        $form->text('relation_type', '关联类型');
        $form->text('relation_id', '关联目标');
        $form->text('operation_type', '操作类型');
        $form->textarea('input', '输入值');

        return $form;
    }
}
