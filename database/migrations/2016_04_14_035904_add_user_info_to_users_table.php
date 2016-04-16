<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserInfoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile_phone', 16)->index()->nullable();
            $table->string('openid', 60)->index()->nullable();
            $table->unsignedTinyInteger('sex')->nullable();
            $table->string('province', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('country', 20)->nullable();
            $table->string('headimgurl')->nullable();
            $table->string('privilege')->nullable();
            $table->string('unionid', 60)->nullable();
            $table->unsignedTinyInteger('subscribe')->nullable();
            $table->unsignedInteger('subscribe_time')->nullable();
            $table->unsignedInteger('unsubscribe_time')->nullable();
            $table->string('remark', 20)->nullable();
            $table->unsignedInteger('groupid')->nullable();
            $table->string('access_token')->nullable();
            $table->string('language', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mobile_phone', 'openid', 'sex',
                'province', 'city', 'country', 'headimgurl',
                'privilege', 'unionid', 'access_token']);
        });
    }
}
