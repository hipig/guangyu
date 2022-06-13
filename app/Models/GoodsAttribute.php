<?php

namespace App\Models;

use App\Models\Concerns\HasOperator;
use App\Models\Concerns\HasRank;
use App\Models\Concerns\HasStatus;

class GoodsAttribute extends Model
{
    use HasOperator, HasRank, HasStatus;

    const TYPE_MAP = 1;
    const TYPE_SEASON = 2;
    const TYPE_GIFT_BAG = 3;
    const TYPE_ITEM = 4;
    public static $typeMap = [
        self::TYPE_MAP => '毕业地图',
        self::TYPE_SEASON => '毕业季节',
        self::TYPE_GIFT_BAG => '稀有礼包',
        self::TYPE_ITEM => '热门物品',
    ];

    protected $fillable = [
        'type',
        'value',
        'created_by',
        'updated_by'
    ];

    public function goods()
    {
        return $this->belongsToMany(Goods::class, 'goods_has_attributes', 'attribute_id', 'goods_id');
    }
}
