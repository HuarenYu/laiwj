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
            $table->string('name', 30);
            //每天单价
            $table->decimal('price', 10, 2)->index();
            //主人名字
            $table->string('hostName', 20);
            //主人电话
            $table->string('hostPhone', 16);
            //国家
            $table->string('country', 20)->index();
            //省
            $table->string('province', 20)->index();
            //城市
            $table->string('city', 20)->index();
            //简介
            $table->string('description', 100);
            //图片
            $table->string('images', 1000);
            //详情
            $table->text('detail');
            //预订时间表
            $table->string('schedule', 1000);
            //所有者
            $table->integer('owner_id')->unsigned()->index();
            //状态 审核中,上线,下线
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
