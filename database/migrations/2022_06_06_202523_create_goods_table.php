<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->string('no')->default('')->comment('编号');
            $table->unsignedTinyInteger('platform')->default(0)->comment('系统平台');
            $table->unsignedTinyInteger('account_type')->default(0)->comment('帐号类型');
            $table->unsignedInteger('candle_count')->default(0)->comment('蜡烛数量');
            $table->unsignedInteger('love_count')->default(0)->comment('爱心数量');
            $table->unsignedInteger('wing_count')->default(0)->comment('翼数量');
            $table->decimal('cost_price', 12)->nullable()->default(0)->comment('成本价');
            $table->decimal('min_price', 12)->nullable()->default(0)->comment('最低价');
            $table->decimal('fixed_price', 12)->nullable()->default(0)->comment('一口价');
            $table->unsignedTinyInteger('is_special')->default(2)->comment('是否特价：1-是 2-否');
            $table->unsignedInteger('progress_rate')->default(0)->comment('表演季进度比');
            $table->unsignedTinyInteger('height')->nullable()->default(0)->comment('身高');
            $table->string('description')->nullable()->comment('其他亮点');
            $table->json('screenshot_images')->nullable()->comment('账号截图');
            $table->boolean('is_generated_cover')->default(false)->comment('是否生成封面');
            $table->unsignedTinyInteger('status')->default(1)->comment('上架状态');
            $table->unsignedTinyInteger('sale_status')->default(1)->comment('销售状态');
            $table->string('created_by', 64)->default('')->comment('创建人');
            $table->string('updated_by', 64)->default('')->comment('更新人');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store');
    }
};
