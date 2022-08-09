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
        $progressName = '';
        $progressRate = 0;
        if (!empty($this->progress_rate)) {
            $progress = $this->progress_rate;
            $progress = end($progress) ?: [];
            $progressName = $progress['name'] ?? '';
            $progressRate = $progress['rate'] ?? 0;
        }

        $res = [
            'progress_name' => $progressName,
            'progress_value' => $progressRate,
            'maps_text' => optional($this->maps)->pluck('value')->implode('，'),
            'seasons_text' => optional($this->seasons)->pluck('value')->implode('，'),
            'gift_bags_text' => optional($this->giftBags)->pluck('value')->implode('，'),
            'hot_items_text' => optional($this->hotItems)->pluck('value')->implode('，'),
        ];
        return $res + parent::toArray($request);
    }
}
