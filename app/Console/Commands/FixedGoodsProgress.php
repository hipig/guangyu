<?php

namespace App\Console\Commands;

use App\Models\Goods;
use Illuminate\Console\Command;

class FixedGoodsProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixed:goods-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fixed Goods Progress';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $page = 1;
        while (true) {
            $pageSize = 20;
            $goods = Goods::query()->paginate($pageSize, '*', 'page', $page);
            foreach ($goods as $item) {
                $item->progress_rate = [["name" => "表演季", "rate" => $item->progress_rate]];
                $item->save();
            }

            if (count($goods) < $pageSize) {
                break;
            }
            $page++;
        }
    }
}
