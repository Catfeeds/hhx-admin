<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHhxTravilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hhx_travils', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',32)->default('')->comment('名字');
            $table->string('topic',32)->default('')->comment('主题');
            $table->decimal('money', 10, 2)->default(0.0)->comment("总金额");
            $table->integer('days')->default(0)->comment('总天数');
            $table->integer('nums')->default(0)->comment('总人数');
            $table->smallInteger('status')->default(0)->comment('0想法1准备2未出发3已出发4已结束');
            $table->date('travil_start')->comment('出发日期');
            $table->date('travil_end')->comment('结束日期');
            $table->string('rating_num',8)->default('0')->comment('打分');
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
        Schema::dropIfExists('hhx_travils');
    }
}
