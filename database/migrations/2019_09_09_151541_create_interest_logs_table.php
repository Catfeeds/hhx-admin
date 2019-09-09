<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interest_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('interest_id')->default(0)->comment('兴趣Id');
            $table->integer('daily_id')->default(0)->comment('日常Id');
            $table->string('illustration',255)->default('')->comment('说明');
            $table->smallInteger('week_day')->default(0)->comment('星期几');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `interest_logs` comment '兴趣记录表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interest_logs');
    }
}
