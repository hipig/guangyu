<?php

namespace App\Admin\Actions\Goods;

use App\Models\Goods;
use App\Models\OperationLog;
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

        $type = $request->status == Goods::STATUS_ENABLE ? OperationLog::OPERATION_TYPE_GOODS_PUTON : OperationLog::OPERATION_TYPE_GOODS_PUTOFF;
        OperationLog::record($model, $type);

        return $this->response()->success('操作成功！')->refresh();
    }

    public function form()
    {
        $this->radio('status', '上架状态')->default($this->row('status'))->options(Goods::$statusMap);
        $this->textarea('operate_remark', '操作备注')->default($this->row('operate_remark'));
    }

}
