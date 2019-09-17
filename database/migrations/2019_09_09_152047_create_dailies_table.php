<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dailies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Img',255)->default('')->comment('每日封面');
            $table->integer('score')->default(0)->comment('每日打分');
            $table->string('collocation',255)->default('')->comment('每日搭配');
            $table->string('grow_up',255)->default('')->comment('每日成长');
            $table->string('summary',255)->default('')->comment('每日总结');
            $table->decimal('money', 10, 2)->default(0.0)->comment("每日消费");
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `dailies` comment '日常'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dailies');
    }
}
