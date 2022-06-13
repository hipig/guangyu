<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\GoodsAttribute;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('仪表盘')
            ->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $count = Goods::query()->count();
                    $column->append(new InfoBox('总商品数', 'circle-o', 'aqua', '/admin/goods', $count));
                });

                $row->column(4, function (Column $column) {
                    $disabledCount = Goods::query()->where('status', Goods::STATUS_DISABLE)->count();
                    $column->append(new InfoBox('下架商品数', 'ban', 'red', '/admin/goods?status=2', $disabledCount));
                });

                $row->column(4, function (Column $column) {
                    $count = GoodsAttribute::query()->count();
                    $column->append(new InfoBox('总属性数', 'cube', 'primary', '/admin/goods-attributes', $count));
                });
            });
    }
}
