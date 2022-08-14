<?php

namespace App\Console\Commands;

use App\Models\Goods;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
     */
    public function handle()
    {
        $page = 1;
        while (true) {
            $pageSize = 20;
            $goods = DB::table('goods')->paginate($pageSize, '*', 'page', $page);
            foreach ($goods as $item) {
                DB::table('goods')->where('id', $item->id)->update([
                    'progress_rate' => json_encode([["name" => "表演季", "rate" => $item->progress_rate]])
                ]);
            }

            if (count($goods) < $pageSize) {
                break;
            }
            $page++;
        }
    }
}
