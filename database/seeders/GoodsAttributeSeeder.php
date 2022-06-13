<?php

namespace Database\Seeders;

use App\Models\GoodsAttribute;
use Illuminate\Database\Seeder;

class GoodsAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes  =[
            GoodsAttribute::TYPE_MAP => [
                "晨岛", "云野", "雨林", "霞谷", "暮土", "禁阁",
            ],
            GoodsAttribute::TYPE_SEASON => [
                "表演季", "潜海季", "风行季", "王子季", "集结季", "梦想季", "预言季", "圣岛季", "魔法季", "音韵季", "归属季", "追光季", "感恩季",
            ],
            GoodsAttribute::TYPE_GIFT_BAG => [
                "多彩绒绒帽", "巫术犄角", "疯女巫长裙", "蛛网朋克", "冥龙南瓜", "茶桌", "情人小船", "冰雪水晶球", "白雪斗篷", "海龟斗篷", "星球夹克", "鲤鱼龙门", "年年有余",
                "雪花发卡", "阳伞", "贝壳", "玉兔", "狐狸背包", "小王子围巾", "粽子", "创始人礼包", "花憩茶几", "tgc", "绊爱套装", "情人跷跷板", "情人秋千", "大桔大利", "新春福娃",
                "暖冬瑞雪", "温暖绒帽", "圣诞鹿角", "巫师帽", "蜘蛛斗篷", "南瓜头", "蝙蝠斗篷", "灯笼",
            ],
            GoodsAttribute::TYPE_ITEM => [
                "白鸟发型", "樱花头", "蝴蝶结", "正太头", "彩虹耳坠", "红耳机", "公主头", "黄鼠狼面具", "红狐狸面具", "花瓣斗篷", "红金斗篷", "白金斗篷", "白鸟斗篷", "灯泡斗篷", "搓澡巾",
                "武士裤", "白棉裤", "笛子", "雨伞", "吉他", "尤克里里", "高音钢琴", "排箫", "铃铛", "耳坠",
            ]
        ];

        foreach ($attributes as $type => $names) {
            $this->createItems($type, $names);
        }
    }

    protected function createItems($type, $names)
    {
        foreach ($names as $name) {
            GoodsAttribute::create(['type' => $type, 'value' => $name]);
        }
    }
}
