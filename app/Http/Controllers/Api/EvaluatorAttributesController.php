<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvaluatorAttributeResource;
use App\Models\EvaluatorAttribute;
use Illuminate\Http\Request;

class EvaluatorAttributesController extends Controller
{
    public function index(Request $request)
    {
        $attributes = EvaluatorAttribute::query()
            ->rank()
            ->enable()
            ->get();
        $attributes->each(function ($attribute) {
           if (in_array($attribute->key, ['gift_bags', 'hot_items'])) {
               $attribute->options = collect($attribute->options)
                   ->map(function ($option) {
                       $option['abbr'] = mb_substr(pinyin_abbr($option['label']), 0, 1);
                       return $option;
                   })->sortBy('abbr')->values()->toArray();
           }
        });

        return EvaluatorAttributeResource::collection($attributes);
    }
}
