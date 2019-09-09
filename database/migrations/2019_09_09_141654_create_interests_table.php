<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',16)->default('')->comment('兴趣名字');
            $table->string('intro',128)->default('')->comment('简述');
            $table->string('Img',255)->default('')->comment('封面');
            $table->smallInteger('status')->default(0)->comment('状态 0打开1关闭');
            $table->smallInteger('order_num')->default(0)->comment('排序');
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
        Schema::dropIfExists('interests');
    }
}
