<?php

namespace App\Admin\Actions\Goods;

use App\Models\Goods;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BatchPutOnOff extends BatchAction
{
    public $name = '批量上下架';

    public function handle(Collection $collection, Request $request)
    {
        foreach ($collection as $model) {
            $model->fill($request->only('status', 'operate_remark'));
            $model->save();
        }

        return $this->response()->success('操作成功！')->refresh();
    }

    public function form()
    {
        $this->radio('status', '上架状态')->default(Goods::STATUS_ENABLE)->options(Goods::$statusMap);
        $this->textarea('operate_remark', '操作备注');
    }
}
