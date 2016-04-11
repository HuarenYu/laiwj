<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            //订单
            $table->increments('id');
            //客户id
            $table->integer('customer_id')->unsigned();
            //入住人姓名
            $table->string('customer_name', 16);
            //入住人电话
            $table->string('customer_phone', 16);
            //入住人数
            $table->integer('customer_count')->unsigned();
            //入住日期
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            //单价
            $table->double('per_price', 10, 2);
            //总价
            $table->double('total_price', 10, 2);
            //客栈id
            $table->integer('inner_id')->unsigned();
            //订单状态
            $table->enum('status', ['created', 'payed', 'refunding', 'canceled', 'finished', 'refunded', 'refund_failed']);
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
        Schema::drop('orders');
    }
}
