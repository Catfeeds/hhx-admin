<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDamaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('actors', 16)->comment('艺人姓名');
            $table->string('cityname', 32)->comment('城市名字');
            $table->string('nameNoHtml', 64)->comment('演唱会名字');
            $table->string('price_str', 32)->comment('价格区间');
            $table->string('showtime', 64)->comment('演绎时间');
            $table->string('venue', 64)->comment('场馆');
            $table->string('showstatus', 16)->comment('艺人姓名');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("alter table `damais` comment'大麦爬取表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('damais');
    }
}
