<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\GoodsAttribute;
use Illuminate\Http\Request;

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

        $mainAttributes = GoodsAttribute::query()
            ->where('status', GoodsAttribute::STATUS_ENABLE)
            ->latest()
            ->get()
            ->groupBy('type')
            ->mapWithKeys(function ($items, $key) {
                $keys = [1 => 'maps', 2 => 'seasons', 3 => 'gift_bags', 4 => 'hot_items'];
                $row['name'] = GoodsAttribute::$typeMap[$key] ?? '';
                $row['items'] = $items->sortBy('rank')->pluck('value', 'id');
                return [$keys[$key] => $row];
            });
        $mainAttributes['height'] = [
            'name' => '身高',
            'items' => Goods::$heightMap,
        ];

        return response()->json(['base' => $baseAttributes, 'main' => $mainAttributes]);
    }
}
