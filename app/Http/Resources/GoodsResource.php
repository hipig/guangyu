<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GoodsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $res = [
            'maps_text' => optional($this->maps)->pluck('value')->implode('，'),
            'seasons_text' => optional($this->seasons)->pluck('value')->implode('，'),
            'gift_bags_text' => optional($this->giftBags)->pluck('value')->implode('，'),
            'hot_items_text' => optional($this->hotItems)->pluck('value')->implode('，'),
        ];
        return $res + parent::toArray($request);
    }
}
