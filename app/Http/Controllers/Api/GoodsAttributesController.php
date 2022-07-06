<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\GoodsAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GoodsAttributesController extends Controller
{
    public function index(Request $request)
    {
        $baseAttributes = [
            'platform' => [
                'name' => '平台',
                'items' => Goods::$platformMap
            ],
            'account_type' => [
                'name' => '账号类型',
                'items' => Goods::$accountTypeMap
            ],
        ];

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

        $mainAttributes['height'] = [
            'name' => '身高',
            'items' => collect(Goods::$heightMap)->map(function ($item, $key) {
                return ['id' => $key, 'value' => $item];
            }),
        ];

        return response()->json(['base' => $baseAttributes, 'main' => $mainAttributes]);
    }
}
