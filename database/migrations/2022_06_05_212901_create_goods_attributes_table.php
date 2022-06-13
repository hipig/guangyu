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
        Schema::create('goods_attributes', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(0)->comment('属性类型');
            $table->string('value')->comment('属性值');
            $table->integer('rank')->default(0)->comment('排序');
            $table->unsignedTinyInteger('status')->default(1)->comment('状态：1-启用 2-禁用');
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
        Schema::dropIfExists('goods_attributes');
    }
};
