<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direction_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('direction_id')->default(0)->comment('方向Id');
            $table->integer('daily_id')->default(0)->comment('日常Id');
            $table->smallInteger('status')->default(0)->comment('方向0减少1增加');
            $table->smallInteger('ok')->default(0)->comment('0ok1bad');
            $table->string('illustration',16)->default('')->comment('说明');
            $table->decimal('money', 10, 2)->default(0.0)->comment("金额");
            $table->smallInteger('week_day')->default(0)->comment('星期几');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `direction_logs` comment '方向记录表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direction_logs');
    }
}
