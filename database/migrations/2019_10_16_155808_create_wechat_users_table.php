<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unionid',32)->default('')->comment('unionid');
            $table->string('openid',32)->default('')->comment('openid');
            $table->string('subscribe_time',32)->default('')->comment('subscribe_time');
            $table->string('nickname',32)->default('')->comment('nickname');
            $table->string('avatar',255)->default('')->comment('avatar');
            $table->string('sex',8)->default('')->comment('sex');
            $table->string('province',32)->default('')->comment('province');
            $table->string('city',32)->default('')->comment('city');
            $table->string('country',32)->default('')->comment('country');


            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `wechat_users` comment '微信用户'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_users');
    }
}
