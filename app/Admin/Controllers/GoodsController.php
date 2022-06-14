<?php

namespace App\Admin\Controllers;

use App\Admin\Selectable\GoodsGiftBags;
use App\Admin\Selectable\GoodsHotItems;
use App\Admin\Selectable\GoodsMaps;
use App\Admin\Selectable\GoodsSeasons;
use App\Models\Goods;
use App\Models\GoodsAttribute;
use Encore\Admin\Auth\Permission;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

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
        $grid->column('no', '编号');
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
        $grid->column('status', '上架状态')->editable('select', Goods::$statusMap);
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
            $form->text('no', '编号')->rules('required');
            $form->radio('platform', '系统')->default(Goods::PLATFORM_ANDROID)->options(Goods::$platformMap)->rules('required');
            $form->select('account_type', '账号类型')->options(Goods::$accountTypeMap)->rules('required');

            $form->text('candle_count', '蜡烛数量')->default(0)->icon('fa-circle-o')->rules('required');
            $form->text('love_count', '爱心数量')->default(0)->icon('fa-circle-o')->rules('required');
            $form->text('wing_count', '翼数量')->default(0)->icon('fa-circle-o')->rules('required');

            $form->text('cost_price', '成本价')->placeholder('0.00')->icon('fa-money')->rules('required');
            $form->text('min_price', '最低价')->placeholder('0.00')->icon('fa-money')->rules('required');
            $form->text('fixed_price', '一口价')->placeholder('0.00')->icon('fa-money')->rules('required');
            $form->radio('is_special', '是否为特价')->default(2)->options([2 => '否', 1 => '是']);

            $form->slider('progress_rate', '表演季进度')->options([
                'max'       => 100,
                'min'       => 0,
                'step'      => 1,
                'postfix'   => '%'
            ]);
            $form->select('height', '身高')->options(Goods::$heightMap);
            $form->textarea('description', '其他亮点');
            $form->radio('status', '上架状态')->default(Goods::STATUS_ENABLE)->options(Goods::$statusMap);
        });

        $form->tab('主要信息', function (Form $form) {
            $maps = GoodsAttribute::query()->where('type', GoodsAttribute::TYPE_MAP)->pluck('value', 'id');
            $seasons = GoodsAttribute::query()->where('type', GoodsAttribute::TYPE_SEASON)->pluck('value', 'id');
            $giftBags = GoodsAttribute::query()->where('type', GoodsAttribute::TYPE_GIFT_BAG)->pluck('value', 'id');
            $hotItems = GoodsAttribute::query()->where('type', GoodsAttribute::TYPE_ITEM)->pluck('value', 'id');

            $form->checkbox('maps', '已毕业地图')->options($maps);
            $form->checkbox('seasons', '已毕业季节')->options($seasons);
            $form->checkbox('giftBags', '稀有礼包')->options($giftBags);
            $form->checkbox('hotItems', '热门物品')->options($hotItems);
        });

        $form->tab('详情图片', function (Form $form) {
            $form->multipleImage('screenshot_images', '截图上传')->removable()->sortable();
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
