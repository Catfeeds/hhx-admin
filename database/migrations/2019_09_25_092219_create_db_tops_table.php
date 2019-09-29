<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbTopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('db_tops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no')->default(0)->comment('排名');
            $table->string('img',255)->default('')->comment('封面图片');
            $table->string('c_title',32)->default('')->comment('中文名');
            $table->string('w_title',255)->default('')->comment('外文名');
            $table->string('rating_num',8)->default('')->comment('打分');
            $table->string('inq',64)->default('')->comment('标语');
            $table->string('comment_num',32)->default('')->comment('评论数');
            $table->string('url',255)->default('')->comment('豆瓣链接');
            $table->string('director',64)->default('')->comment('导演');
            $table->string('screen_writer',255)->default('')->comment('编剧');
            $table->string('actor',1024)->default('')->comment('主演');
            $table->string('type',64)->default('')->comment('类型');
            $table->string('time_long',32)->default('')->comment('时长');
            $table->string('release_date',255)->default('')->comment('上映日期');
            $table->string('intro',1024)->default('')->comment('简介');
            $table->string('year',8)->default('')->comment('年限');
            $table->smallInteger('status')->default(0)->comment('0未看1已看2不看');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `db_tops` comment '豆瓣Top250'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('db_tops');
    }
}
