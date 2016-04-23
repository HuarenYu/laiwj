<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            //相册
            $table->increments('id');
            //相册内容
            $table->string('content')->nullable();
            //相册图片[{url:,desc:}]
            $table->text('images');
            //相册所属的客栈
            $table->unsignedInteger('inn_id')->index();
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
        Schema::drop('albums');
    }
}
