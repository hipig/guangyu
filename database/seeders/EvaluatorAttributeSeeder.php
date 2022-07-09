<?php

namespace Database\Seeders;

use App\Models\EvaluatorAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvaluatorAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = [
            [
                'key' => 'account_from',
                'label' => '帐号来源',
                'type' => 'radio',
                'options' => [
                    [
                        'key' => 1,
                        'label' => '自己注册',
                        'value' => 0,
                    ],
                    [
                        'key' => 2,
                        'label' => '购买的',
                        'value' => 0,
                    ]
                ],
                'is_compute' => false
            ],
            [
                'key' => 'platform',
                'label' => '区服',
                'type' => 'radio',
                'options' => [
                    [
                        'key' => 1,
                        'label' => '国服安卓官服',
                        'value' => 0,
                    ],
                    [
                        'key' => 2,
                        'label' => '国服ios',
                        'value' => 0,
                    ],
                    [
                        'key' => 3,
                        'label' => '其他',
                        'value' => 0,
                    ]
                ],
                'is_compute' => false
            ],
            [
                'key' => 'change_binding',
                'label' => '换绑记录',
                'type' => 'radio',
                'options' => [
                    [
                        'key' => 1,
                        'label' => '无换绑记录',
                        'value' => 0,
                    ],
                    [
                        'key' => 2,
                        'label' => '一个月前',
                        'value' => 0,
                    ],
                    [
                        'key' => 3,
                        'label' => '一个月内',
                        'value' => 0,
                    ]
                ],
                'is_compute' => false
            ],
            [
                'key' => 'login_type',
                'label' => '登录方式',
                'type' => 'radio',
                'options' => [
                    [
                        'key' => 'phone',
                        'label' => '手机',
                        'value' => 0,
                    ],
                    [
                        'key' => 'email',
                        'label' => '邮箱',
                        'value' => 0,
                    ],
                    [
                        'key' => 'other',
                        'label' => '其他',
                        'value' => 0,
                    ]
                ],
                'is_compute' => false
            ],
            [
                'key' => 'anti_addiction',
                'label' => '防沉迷',
                'type' => 'radio',
                'options' => [
                    [
                        'key' => 2,
                        'label' => '否',
                        'value' => 0,
                    ],
                    [
                        'key' => 1,
                        'label' => '是',
                        'value' => 0,
                    ]
                ],
                'is_compute' => false
            ],
            [
                'key' => 'wish_price',
                'label' => '出售的心理价位',
                'type' => 'input',
                'value' => '',
                'is_compute' => false
            ],
            [
                'key' => 'candle_count',
                'label' => '蜡烛数量',
                'type' => 'input',
                'value' => '0.06'
            ],
            [
                'key' => 'wing_count',
                'label' => '翼数量',
                'type' => 'input',
                'value' => '',
                'is_compute' => false
            ],
            [
                'key' => 'love_count',
                'label' => '爱心数量',
                'type' => 'input',
                'value' => '0.3'
            ],
            [
                'key' => 'height',
                'label' => '身高',
                'type' => 'input',
                'value' => '',
                'is_compute' => false
            ],
            [
                'key' => 'progress_rate',
                'label' => '表演季进度百分比',
                'type' => 'input',
                'value' => '',
                'is_compute' => false
            ],
            [
                'key' => 'maps',
                'label' => '已毕业地图',
                'type' => 'checkbox',
                'options' => [
                    [
                        'key' => 1,
                        'label' => '晨岛',
                        'value' => '20',
                    ],
                    [
                        'key' => 2,
                        'label' => '云野',
                        'value' => '20',
                    ],
                    [
                        'key' => 3,
                        'label' => '雨林',
                        'value' => '30',
                    ],
                    [
                        'key' => 4,
                        'label' => '峡谷',
                        'value' => '30',
                    ],
                    [
                        'key' => 5,
                        'label' => '暮土',
                        'value' => '30',
                    ],
                    [
                        'key' => 6,
                        'label' => '禁阁',
                        'value' => '30',
                    ],
                ]
            ],
            [
                'key' => 'seasons',
                'label' => '已毕业季节',
                'type' => 'checkbox',
                'options' => [
                    [
                        'key' => 1,
                        'label' => '表演季',
                        'value' => '40',
                    ],
                    [
                        'key' => 2,
                        'label' => '潜海季',
                        'value' => '50',
                    ],
                    [
                        'key' => 3,
                        'label' => '风行季',
                        'value' => '50',
                    ],
                    [
                        'key' => 4,
                        'label' => '王子季',
                        'value' => '60',
                    ],
                    [
                        'key' => 5,
                        'label' => '集结季',
                        'value' => '80',
                    ],
                    [
                        'key' => 6,
                        'label' => '梦想季',
                        'value' => '80',
                    ],
                    [
                        'key' => 7,
                        'label' => '预言季',
                        'value' => '100',
                    ],
                    [
                        'key' => 8,
                        'label' => '圣岛季',
                        'value' => '120',
                    ],
                    [
                        'key' => 9,
                        'label' => '魔法季',
                        'value' => '200',
                    ],
                    [
                        'key' => 10,
                        'label' => '音韵季',
                        'value' => '',
                    ],
                    [
                        'key' => 11,
                        'label' => '归属季',
                        'value' => '',
                    ],
                    [
                        'key' => 12,
                        'label' => '追光季',
                        'value' => '',
                    ],
                    [
                        'key' => 13,
                        'label' => '感恩季',
                        'value' => '',
                    ],

                ]
            ],
        ];

        $giftBags = [
            "多彩绒绒帽", "巫术犄角", "疯女巫长裙", "蛛网朋克", "冥龙南瓜", "茶桌", "情人小船", "冰雪水晶球", "白雪斗篷", "海龟斗篷", "星球夹克", "鲤鱼龙门", "年年有余",
            "雪花发卡", "阳伞", "贝壳", "玉兔", "狐狸背包", "小王子围巾", "粽子", "创始人礼包", "花憩茶几", "tgc", "绊爱套装", "情人跷跷板", "情人秋千", "大桔大利", "新春福娃",
            "暖冬瑞雪", "温暖绒帽", "圣诞鹿角", "巫师帽", "蜘蛛斗篷", "南瓜头", "蝙蝠斗篷", "灯笼",
        ];
        $giftOptions = [];
        foreach ($giftBags as $index => $value) {
            $giftOptions[] = [
                'key' => $index+1,
                'label' => $value,
                'value' => 10
            ];
        }
        $attributes[] = [
            'key' => 'gift_bags',
            'label' => '稀有礼包',
            'type' => 'checkbox',
            'options' => $giftOptions
        ];

        $hotItems = [
            "白鸟发型", "樱花头", "蝴蝶结", "正太头", "彩虹耳坠", "红耳机", "公主头", "黄鼠狼面具", "红狐狸面具", "花瓣斗篷", "红金斗篷", "白金斗篷", "白鸟斗篷", "灯泡斗篷", "搓澡巾",
            "武士裤", "白棉裤", "笛子", "雨伞", "吉他", "尤克里里", "高音钢琴", "排箫", "铃铛", "耳坠",
        ];
        $itemOptions = [];
        foreach ($hotItems as $index => $value) {
            $itemOptions[] = [
                'key' => $index+1,
                'label' => $value,
                'value' => 5
            ];
        }
        $attributes[] = [
            'key' => 'hot_items',
            'label' => '热门物品',
            'type' => 'checkbox',
            'options' => $itemOptions
        ];

        $attributes[] = [
            'key' => 'other_remark',
            'label' => '其他亮点',
            'type' => 'textarea',
            'is_compute' => false
        ];

        foreach ($attributes as $attribute) {
            EvaluatorAttribute::create($attribute);
        }
    }
}
