<?php

namespace App\Admin\Controllers;

use App\Http\Requests\Admin\EvaluateRequest;
use App\Models\EvaluatorAttribute;
use App\Models\EvaluatorRecord;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Form as WidgetForm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EvaluatorRecordsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '估价记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EvaluatorRecord());

        $grid->column('code', '编码');
        $grid->column('content_result', '估价内容')->display(function ($value){
            return str_replace("\n", "<br>", str_replace("\r\n", "\n", $value));
        });
        $grid->column('created_at', '创建时间');

        $grid->filter(function($filter) {
            $filter->equal('code', '编码');
        });

        $grid->disableCreateButton();
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
            $actions->disableEdit();
            $actions->disableDelete();
        });

        return $grid;
    }

    protected function form()
    {
        return new Form(new EvaluatorRecord());
    }

    public function evaluate(Content $content)
    {
        return $content
            ->title('开始估价')
            ->body(view('admin.evaluator.form'));
    }

    public function submitEvaluate(EvaluateRequest $request)
    {
        Permission::check('evaluator.records.evaluate');

        $content = explode("\n", str_replace("\r\n", "\n", $request->input('content')));
        if (Str::startsWith($content[0], '编号')) {
            $code = explode('：', $content[0])[1] ?? "";
            $attributes = EvaluatorAttribute::query()->where('is_compute', true)->enable()->get()->keyBy('key')->toArray();
            $record = EvaluatorRecord::query()->where('code', $code)->first();
            $totalAmount = 0;
            $result = [];
            foreach ($record->content ?? [] as $key => $value) {
                if (isset($attributes[$key])) {
                    $attribute = $attributes[$key];
                    switch ($attribute['type']) {
                        case EvaluatorAttribute::TYPE_RADIO:
                            $options = array_column($attribute['options'], null, 'key');
                            if (isset($options[$value])) {
                                $amount = $attribute[$value]['value'] ?: 0;
                                $totalAmount += $amount;
                                $result[] = "{$attribute['label']}：{$amount}";
                            }
                            break;
                        case EvaluatorAttribute::TYPE_CHECKBOX:
                            $options = array_column($attribute['options'], null, 'key');
                            $amountText = '';
                            $amountItem = 0;
                            foreach ($value as $k => $v) {
                                if (isset($options[$v])) {
                                    $amount = $options[$v]['value'] ?: 0;
                                    $amountItem += $amount;
                                    $amountText .= $k === 0 ? $amount : '+' . $amount;
                                }
                            }
                            $totalAmount += $amountItem;
                            $result[] = "{$attribute['label']}：$amountText=$amountItem";
                            break;
                        case EvaluatorAttribute::TYPE_INPUT:
                            $amount = $attribute['value'] ?: 0;
                            $amountItem = floatval($amount) * intval($value);
                            $amountText = "{$amount}×{$value}";
                            $totalAmount += $amountItem;
                            $result[] = "{$attribute['label']}：$amountText=$amountItem";
                            break;
                        default:
                            $amount = $attribute['value'] ?: 0;
                            $totalAmount += $amount;
                            $result[] = "{$attribute['label']}：$amount";
                    }
                }
            }
            $result[] = "总计：<h1>$totalAmount</h1>";

            admin_success('估价结果', implode("<br>", $result));
        }
        return back();
    }
}
