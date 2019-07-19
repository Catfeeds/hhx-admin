<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeiboPicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weibo_pics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url',255)->nullable()->default('')->comment('weibo图片');
            $table->string('weibo_info_id',16)->nullable()->default('')->comment('微博信息Id');
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
        Schema::dropIfExists('weibo_pics');
    }
}
