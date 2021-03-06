<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GoodsResource;
use App\Models\Goods;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function index(Request $request)
    {
        $query = Goods::query()
            ->where('status', Goods::STATUS_ENABLE)
            ->where('is_generated_cover', true);

        if ($request->get('platform')) {
            $query->where('platform', $request->get('platform'));
        }
        if ($request->get('account_type')) {
            $query->where('account_type', $request->get('account_type'));
        }
        if ($request->has('height')) {
            $query->whereIn('height', (array)$request->get('height'));
        }
        if ($request->boolean('is_special')) {
            $query->where('is_special', Goods::SPECIAL_STATUS_ON);
        }
        if ($maps = (array)$request->get('maps')) {
            $query->whereHas('maps', function (Builder $query) use ($maps) {
                $query->whereIn('attribute_id', $maps);
            }, "=", count($maps));
        }
        if ($seasons = (array)$request->get('seasons')) {
            $query->whereHas('seasons', function (Builder $query) use ($seasons) {
                $query->whereIn('attribute_id', $seasons);
            }, "=", count($seasons));
        }
        if ($giftBags = (array)$request->get('gift_bags')) {
            $query->whereHas('giftBags', function (Builder $query) use ($giftBags) {
                $query->whereIn('attribute_id', $giftBags);
            }, "=", count($giftBags));
        }
        if ($hotItems = (array)$request->get('hot_items')) {
            $query->whereHas('hotItems', function (Builder $query) use ($hotItems) {
                $query->whereIn('attribute_id', $hotItems);
            }, "=", count($hotItems));
        }

        if ($request->get('price_range')) {
            switch ($request->get('price_range')) {
                case 1:
                    $query->where('fixed_price', '<=', 1000);
                    break;
                case 2:
                    $query->where('fixed_price', '>', 1000);
                    $query->where('fixed_price', '<=', 2000);
                    break;
                case 3:
                    $query->where('fixed_price', '>', 2000);
                    $query->where('fixed_price', '<=', 3000);
                    break;
                case 4:
                    $query->where('fixed_price', '>', 3000);
                    $query->where('fixed_price', '<=', 5000);
                    break;
                default:
                    $query->where('fixed_price', '>', 5000);
            }
        }

        switch ($request->get('sort_type')) {
            case 2:
                $query->oldest();
                break;
            case 3:
                $query->orderBy('fixed_price');break;
            case 4:
                $query->orderBy('fixed_price', 'desc');
                break;
            default:
                $query->latest();
        }

        $goods = $query->paginate(20);

        return GoodsResource::collection($goods);
    }

    public function show(Request $request, Goods $goods)
    {
        $goods->load(['maps', 'seasons', 'giftBags', 'hotItems']);
        return GoodsResource::make($goods);
    }
}
