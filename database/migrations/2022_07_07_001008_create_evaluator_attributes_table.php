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
        Schema::create('evaluator_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('标识');
            $table->string('label')->comment('名称');
            $table->string('type', 56)->comment('属性类型');
            $table->text('options')->nullable()->comment('属性选项');
            $table->string('value')->nullable()->comment('属性价值');
            $table->boolean('is_compute')->default(true)->comment('是否参与计算');
            $table->integer('rank')->default(0)->comment('排序');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态：1-启用 2-禁用');
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
        Schema::dropIfExists('evaluator_attributes');
    }
};
