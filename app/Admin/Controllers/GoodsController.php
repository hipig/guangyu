<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Goods\BatchPutOnOff;
use App\Admin\Actions\Goods\PutOnOff;
use App\Models\Goods;
use App\Models\GoodsAttribute;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Cache;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class GoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品';

    public function index(Content $content)
    {
        Permission::check('goods');
        return parent::index($content);
    }

    public function create(Content $content)
    {
        Permission::check('goods.create');
        return parent::create($content);
    }

    public function edit($id, Content $content)
    {
        Permission::check('goods.edit');
        return parent::edit($id, $content);
    }

    public function destroy($id)
    {
        Permission::check('goods.destroy');
        return parent::destroy($id);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Goods());
        $grid->model()->orderBy('status')->latest();
        $grid->column('no', '编号')->display(function ($no) {
            return "<a href='/store/detail?id={$this->id}' target='_blank'>{$no}</a>";
        });
        $grid->column('platform_text', '平台');
        $grid->column('account_type_text', '帐号类型');
        $grid->column('candle_count', '蜡烛数量');
        $grid->column('love_count', '爱心数量');
        $grid->column('wing_count', '翼数量');
        $grid->column('cost_price', '成本价');
        $grid->column('min_price', '最低价');
        $grid->column('fixed_price', '一口价');
        $grid->column('progress_rate', '表演季进度')->display(function ($value) {
           return $value . '%';
        });
        $grid->column('height_text', '身高');
        $grid->column('is_generated_cover', '已生成封面')->bool();
        $grid->column('status', '上架状态')->using(Goods::$statusMap);
        $grid->column('created_by', '创建人');
        $grid->column('created_at', '创建时间');

        $grid->filter(function($filter) {
            $filter->like('no', '编号');
            $filter->equal('platform', '平台')->radio(Goods::$platformMap);
            $filter->equal('account_type', '账号类型')->select(Goods::$accountTypeMap);
            $filter->equal('status', '上架状态')->radio(['' => '默认', 1 => '上架', 2 => '下架']);
        });

        $grid->actions(function ($actions) {
            $actions->disableView();
            if (Admin::user()->cannot('goods.edit')) {
                $actions->disableEdit();
            }
            if (Admin::user()->cannot('goods.destroy')) {
                $actions->disableDelete();
            }

            $actions->add(new PutOnOff());
        });

        $grid->batchActions(function ($batch) {
            $batch->add(new BatchPutOnOff());
        });

        if (Admin::user()->cannot('goods.create')) {
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
        $form = new Form(new Goods());

        $form->tab('基础信息', function (Form $form) {
            $form->text('no', '编号')->creationRules(['required', "unique:goods"])->updateRules(['required', "unique:goods,no,{{id}}"]);
            $form->radio('platform', '系统')->default(Goods::PLATFORM_ANDROID)->options(Goods::$platformMap)->rules('required');
            $form->select('account_type', '账号类型')->options(Goods::$accountTypeMap)->rules('required');

            $form->text('candle_count', '蜡烛数量')->default(0)->icon('fa-circle-o')->rules('required');
            $form->text('love_count', '爱心数量')->default(0)->icon('fa-circle-o')->rules('required');
            $form->text('wing_count', '翼数量')->default(0)->icon('fa-circle-o')->rules('required');

            $form->text('cost_price', '成本价')->placeholder('0.00')->icon('fa-money')->rules('required');
            $form->text('min_price', '最低价')->placeholder('0.00')->icon('fa-money')->rules('required');
            $form->text('fixed_price', '一口价')->placeholder('0.00')->icon('fa-money')->rules('required');
            $form->radio('is_special', '是否为特价')->default(2)->options([2 => '否', 1 => '是']);
            $form->text('progress_rate', '表演季进度')->default(0)->append('%')->rules('integer|min:0|max:100');
            $form->select('height', '身高')->default(Goods::HEIGHT_OTHER)->options(Goods::$heightMap);
            $form->textarea('description', '其他亮点');

        });

        $form->tab('主要信息', function (Form $form) {
            if (!$mainAttributes = Cache::get(GoodsAttribute::CACHE_KEY)) {
                $mainAttributes = GoodsAttribute::query()
                    ->where('status', GoodsAttribute::STATUS_ENABLE)
                    ->latest()
                    ->get()
                    ->groupBy('type')
                    ->mapWithKeys(function ($items, $key) {
                        $keys = [GoodsAttribute::TYPE_MAP => 'maps', GoodsAttribute::TYPE_SEASON => 'seasons', GoodsAttribute::TYPE_GIFT_BAG => 'gift_bags', GoodsAttribute::TYPE_ITEM => 'hot_items'];
                        $sortBy = in_array($key, [GoodsAttribute::TYPE_MAP, GoodsAttribute::TYPE_SEASON]) ? [['rank', 'asc'], ['created_at', 'desc']] : [['abbr', 'asc'], ['rank', 'asc'], ['created_at', 'desc']];

                        $row['key'] = $key;
                        $row['name'] = GoodsAttribute::$typeMap[$key] ?? '';
                        $row['items'] = $items->map(function ($item) {
                            $item['abbr'] = mb_substr(pinyin_abbr($item->value), 0, 1);
                            return $item;
                        })->sortBy($sortBy)->values()->toArray();
                        return [$keys[$key] => $row];
                    })->sortBy('key');

                $expiredAt = now()->addDays(7);
                Cache::put(GoodsAttribute::CACHE_KEY, $mainAttributes, $expiredAt);
            }

            $form->checkbox('maps', '已毕业地图')->options(collect($mainAttributes['maps']['items'])->pluck('value', 'id'));
            $form->checkbox('seasons', '已毕业季节')->options(collect($mainAttributes['seasons']['items'])->pluck('value', 'id'));
            $form->checkbox('giftBags', '稀有礼包')->options(collect($mainAttributes['gift_bags']['items'])->pluck('value', 'id'));
            $form->checkbox('hotItems', '热门物品')->options(collect($mainAttributes['hot_items']['items'])->pluck('value', 'id'));
        });

        $form->tab('详情图片', function (Form $form) {
            $form->multipleImage('screenshot_images', '截图上传')->removable()->sortable()->thumbnail('m', 480, null);
        });

        $form->tab('上下架', function (Form $form) {
            $form->radio('status', '上架状态')->default(Goods::STATUS_ENABLE)->options(Goods::$statusMap);
            $form->textarea('operate_remark', '操作备注');
        });

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            if (Admin::user()->cannot('goods')) {
                $tools->disableList();
            }
            if (Admin::user()->cannot('goods.destroy')) {
                $tools->disableDelete();
            }
        });

        return $form;
    }
}
