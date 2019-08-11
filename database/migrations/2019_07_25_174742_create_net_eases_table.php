<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetEasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('net_eases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('singNo',32)->default('')->comment('歌手编号');
            $table->string('songUrl',255)->default('')->comment('歌曲链接');
            $table->string('singName',32)->default('')->comment('歌手名字');
            $table->string('songName',255)->default('')->comment('歌曲名字');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `net_eases` comment '网易云'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('net_eases');
    }
}
