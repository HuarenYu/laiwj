<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inns', function (Blueprint $table) {
            //客栈
            $table->increments('id');
            //名字
            $table->string('name', 20);
            //简介
            $table->string('description', 100);
            //图片
            $table->string('images', 1000);
            //详情
            $table->text('detail');
            //预订时间表
            $table->string('schedule', 1000);
            //所有者
            $table->integer('owner_id')->unsigned();
            //状态
            $table->enum('status', ['pending', 'online', 'offline']);
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
        Schema::drop('inns');
    }
}
