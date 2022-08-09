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
        Schema::create('operation_logs', function (Blueprint $table) {
            $table->id();
            $table->string('relation_type')->comment('关联表名');
            $table->unsignedBigInteger('relation_id')->comment('关联ID');
            $table->string('relation_name')->comment('关联名称');
            $table->string('operation_type')->comment('操作类型');
            $table->text('input')->nullable()->comment('请求参数');
            $table->string('operation_by')->nullable()->comment('操作人');
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
        Schema::dropIfExists('operation_logs');
    }
};
