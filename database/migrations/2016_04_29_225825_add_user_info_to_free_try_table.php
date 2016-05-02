<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserInfoToFreeTryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('free_tries', function (Blueprint $table) {
            //职业
            $table->string('career', 20);
            //性别
            $table->enum('gender', ['男', '女']);
            //出发地
            $table->string('from', 20);
            //年龄
            $table->string('age', 20);
            //预计体验时间
            $table->string('exp_time', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('free_tries', function (Blueprint $table) {
            $table->dropColumn(['career', 'gender', 'from', 'age', 'exp_time']);
        });
    }
}
