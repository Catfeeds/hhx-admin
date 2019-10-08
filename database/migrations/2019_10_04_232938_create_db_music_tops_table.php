<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbMusicTopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('db_music_tops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no')->default(0)->comment('排名');
            $table->string('img',255)->default('')->comment('封面图片');
            $table->string('title',64)->default('')->comment('中文名');
            $table->string('sing_name',32)->default('')->comment('歌手名');
            $table->string('date',16)->default('')->comment('日期');
            $table->string('album',16)->default('')->comment('专辑/单曲');
            $table->string('cd',16)->default('')->comment('CD');
            $table->string('type',64)->default('')->comment('类型');
            $table->string('star',16)->default('')->comment('评分');
            $table->string('comment',16)->default('')->comment('评价');
            $table->text('intro')->comment('简介');
            $table->text('songs')->comment('曲目');
            $table->smallInteger('status')->default(0)->comment('0未看1已看2不看');
            $table->string('pan_code',8)->default('')->comment('网盘code');
            $table->string('pan_url',255)->default('')->comment('网盘链接');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `db_music_tops` comment '豆瓣音乐Top250'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('db_music_tops');
    }
}
