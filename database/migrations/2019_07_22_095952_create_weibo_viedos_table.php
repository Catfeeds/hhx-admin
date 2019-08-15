<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeiboViedosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weibo_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url',255)->nullable()->default('')->comment('weibo视频地址');
            $table->string('weibo_info_id',16)->nullable()->default('')->comment('微博信息Id');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `weibo_videos` comment '微博视频表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weibo_viedos');
    }
}
