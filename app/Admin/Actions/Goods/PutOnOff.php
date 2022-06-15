<?php

namespace App\Admin\Actions\Goods;

use App\Models\Goods;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PutOnOff extends RowAction
{
    public $name = '上下架';

    public function handle(Model $model, Request $request)
    {
        $model->fill($request->only('status', 'operate_remark'));
        $model->save();

        return $this->response()->success('操作成功！')->refresh();
    }

    public function form()
    {
        $this->radio('status', '上架状态')->default($this->row('status'))->options(Goods::$statusMap);
        $this->textarea('operate_remark', '操作备注')->default($this->row('operate_remark'));
    }

}
