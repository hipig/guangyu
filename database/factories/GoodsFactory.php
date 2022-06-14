<?php

namespace Database\Factories;

use App\Models\Goods;
use App\Models\GoodsAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Goods>
 */
class GoodsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'no' => Goods::findAvailableNo(),
            'platform' => $this->faker->randomElement(array_keys(Goods::$platformMap)),
            'account_type' => $this->faker->randomElement(array_keys(Goods::$accountTypeMap)),
            'candle_count' => $this->faker->randomNumber(3),
            'love_count' => $this->faker->randomNumber(2),
            'wing_count' => $this->faker->randomNumber(3),
            'cost_price' => $this->faker->randomFloat(5000),
            'min_price' => $this->faker->randomFloat(5000),
            'fixed_price' => $this->faker->randomFloat(5000),
            'progress_rate' => $this->faker->randomNumber(2),
            'height' => $this->faker->randomElement(array_keys(Goods::$heightMap)),
            'created_by' => '超级管理员'
        ];
    }

    public function configure()
    {
        $mapIds = GoodsAttribute::query()->where('type', GoodsAttribute::TYPE_MAP)->pluck('id');
        $seasonIds = GoodsAttribute::query()->where('type', GoodsAttribute::TYPE_SEASON)->pluck('id');
        $bagIds = GoodsAttribute::query()->where('type', GoodsAttribute::TYPE_GIFT_BAG)->pluck('id');
        $itemIds = GoodsAttribute::query()->where('type', GoodsAttribute::TYPE_ITEM)->pluck('id');


        return $this->afterCreating(function (Goods $goods) use ($mapIds, $seasonIds, $bagIds, $itemIds) {
            $goods->maps()->sync($this->faker->randomElements($mapIds, $this->faker->randomElement([1, 2, 3, 4])));
            $goods->seasons()->sync($this->faker->randomElements($seasonIds, $this->faker->randomElement([1, 2, 3, 4, 5, 6])));
            $goods->giftBags()->sync($this->faker->randomElements($bagIds, $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8])));
            $goods->hotItems()->sync($this->faker->randomElements($itemIds, $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8])));
        });
    }
}
