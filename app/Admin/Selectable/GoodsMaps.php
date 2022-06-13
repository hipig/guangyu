<?php

namespace App\Admin\Selectable;

use App\Models\GoodsAttribute;
use Encore\Admin\Grid\Selectable;

class GoodsMaps extends Selectable
{
    public $model = GoodsAttribute::class;

    public function make()
    {
        $this->model()->where('type', GoodsAttribute::TYPE_MAP);
        $this->column('value', '地图名称');
        $this->column('created_at', '创建时间');

        $this->filter(function($filter) {
            $filter->like('value', '地图名称');
        });
    }
}
