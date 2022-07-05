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
                    $keys = [1 => 'maps', 2 => 'seasons', 3 => 'gift_bags', 4 => 'hot_items'];
                    $row['name'] = GoodsAttribute::$typeMap[$key] ?? '';
                    $row['items'] = $items->sortBy(function ($item) {
                        return mb_substr(pinyin_abbr($item->value), 0, 1);
                    })->values()->toArray();
                    return [$keys[$key] => $row];
                });

            $expiredAt = now()->addDays(7);
            Cache::put(GoodsAttribute::CACHE_KEY, $mainAttributes, $expiredAt);
        }

        $mainAttributes['height'] = [
            'name' => '身高',
            'items' => collect(Goods::$heightMap)->map(function ($item, $key) {
                return ['id' => $key, 'value' => $item];
            }),
        ];

        return ['base' => $baseAttributes, 'main' => $mainAttributes->toArray()];
    }
}
