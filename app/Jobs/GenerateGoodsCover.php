<?php

namespace App\Jobs;

use App\Models\Goods;
use App\Settings\GeneralSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateGoodsCover implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $goods;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Goods $goods)
    {
        $this->goods = $goods;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $storage = Storage::disk(config('admin.upload.disk'));
        $mainBg = $storage->path(app(GeneralSetting::class)->background_image);

        $image = \Image::make($mainBg)->resize(500, 500);

        // 顶部
        $this->writeHeaderText($image, $this->goods->platform_text . $this->goods->account_type_text, 30, 50);
        $this->writeHeaderText($image, "编号 {$this->goods->no}", 265, 50);

        // 基础信息
        $this->writeLineText($image, "基础信息", 90);
        $this->writeCountText($image, "蜡烛数量：{$this->goods->candle_count}", 15, 140);
        $this->writeCountText($image, "翼数量：{$this->goods->wing_count}", 270, 140);
        $this->writeCountText($image, "爱心数量：{$this->goods->love_count}", 15, 175);
        $this->writeCountText($image, "表演季进度：{$this->goods->progress_rate}%", 270, 175);

        // 主要信息
        $this->writeLineText($image, "主要信息", 200);
        // 已毕业地图
        $startY = 250;
        $this->writeAttributeLabelText($image, "已毕业地图：", 15, $startY);
        $maps = $this->goods->maps()->pluck('value')->toArray();
        $this->writeAttributeContentText($image, $maps, 135, $startY, "#faf9fb");

        // 已毕业季节
        $startY += 30;
        $this->writeAttributeLabelText($image, "已毕业季节：", 15, $startY);
        $seasons = $this->goods->seasons()->pluck('value')->toArray();
        $this->writeAttributeContentText($image, $seasons, 135, $startY, "#faf9fb");

        // 稀有礼包
        $startY += 30;
        $this->writeAttributeLabelText($image, "稀有礼包：", 15, $startY);
        $giftBags = $this->goods->giftBags()->pluck('value')->toArray();
        $this->writeAttributeContentText($image, $giftBags, 115, $startY, "#fef08a");

        // 热门物品
        $startY += 30;
        $this->writeAttributeLabelText($image, "热门物品：", 15, $startY);
        $hotItems = $this->goods->hotItems()->pluck('value')->toArray();
        $this->writeAttributeContentText($image, $hotItems, 115, $startY, "#fef08a");

        if ($this->goods->height > 0) {
            $startY += 30;
            $this->writeAttributeLabelText($image, "身高：", 15, $startY);
            $this->writeAttributeContentText($image, ["{$this->goods->height_text}"], 75, $startY, "#fef08a");
        }

        // 其他亮点
        if ($this->goods->description) {
            $this->writeLineText($image, "其他亮点", $startY + 20);
            $this->writeText($image, "{$this->goods->description}", 15, $startY + 60);
        }

        $image->save(public_path("covers/{$this->goods->no}.jpg"));

        $this->goods->is_generated_cover = true;
        $this->goods->saveQuietly();
    }

    protected function writeHeaderText(&$image, $text, $x, $y)
    {
        $image->text($text, $x, $y, function ($font) {
            $font->file(resource_path('fonts/noto-sans-sc/bold.otf'));
            $font->size(30);
            $font->color('#faf9fb');
        });
    }

    protected function writeLineText(&$image, $text, $y)
    {
        $image->line(0, $y, 190, $y, function ($draw) {
            $draw->color('#fbbf24');
        });
        $image->line(310, $y, 500, $y, function ($draw) {
            $draw->color('#fbbf24');
        });
        $image->text($text, 250, $y+8, function ($font) {
            $font->file(resource_path('fonts/noto-sans-sc/medium.otf'));
            $font->size(20);
            $font->color('#fbbf24');
            $font->align('center');
        });
    }

    protected function writeCountText(&$image, $text, $x, $y)
    {
        $image->text($text, $x, $y, function ($font) {
            $font->file(resource_path('fonts/noto-sans-sc/medium.otf'));
            $font->size(24);
            $font->color('#faf9fb');
        });
    }

    protected function writeAttributeLabelText(&$image, $text, $x, &$y)
    {
        $image->text($text, $x, $y, function ($font) {
            $font->file(resource_path('fonts/noto-sans-sc/medium.otf'));
            $font->size(20);
            $font->color('#df6311');
        });
    }

    protected function writeAttributeContentText(&$image, $texts, $x, &$y, $color)
    {
        $lines = $this->generateTextLines($texts, $x);
        foreach ($lines as $i =>$line) {
            $startX = $i > 0 ? 15 : $x;
            $y = $y + ($i > 0 ? 30 : 0);
            $image->text($line, $startX, $y, function ($font) use ($color) {
                $font->file(resource_path('fonts/noto-sans-sc/medium.otf'));
                $font->size(20);
                $font->color($color);
            });
        }
    }

    protected function writeText(&$image, $text, $x, $y, $size = 20, $color = '#faf9fb')
    {
        $image->text($text, $x, $y, function ($font) use ($size, $color) {
            $font->file(resource_path('fonts/noto-sans-sc/medium.otf'));
            $font->size($size);
            $font->color($color);
        });
    }

    /**
     * 生成文本行
     * @param $wordArr
     * @return array
     * @throws \ImagickDrawException
     * @throws \ImagickException
     */
    protected function generateTextLines($wordArr, $startX = 0)
    {
        $line = [];
        $lines = [];

        $width = 485;
        $lineWidth = $width - $startX;
        foreach ($wordArr as $word) {
            $line[] = $word;

            $im = new \Imagick();
            $draw = new \ImagickDraw();
            $draw->setFont(resource_path('fonts/noto-sans-sc/medium.otf'));
            $draw->setFontSize(20);
            $info = $im->queryFontMetrics($draw, implode("，", $line) . "，");

            if ($info['textWidth'] >= $lineWidth) {
                //-- We have gone to far!
                array_pop($line);
                $lines[] = implode("，", $line) . "，";
                //-- Start new line
                unset($line);
                $line[] = $word;
            }

            if (count($lines) > 1) {
                $lineWidth = $width - 15;
            }
        }

        $lines[] = implode("，", $line);
        return $lines;
    }
}
