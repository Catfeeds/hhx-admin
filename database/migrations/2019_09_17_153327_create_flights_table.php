<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('arrCode',16)->default('')->comment('到达代码');
            $table->string('price',8)->default("")->comment('价格');
            $table->string('discount',8)->default("")->comment('折扣');
            $table->string('arrName',8)->default("")->comment('到达城市');
            $table->string('depName',8)->default("")->comment('出发城市');
            $table->string('depDate',16)->default("")->comment('出发日期');
            $table->string('priceDesc',8)->default("")->comment('元');
            $table->string('depCode',16)->default('')->comment('出发代码');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `flights` comment '飞猪航班'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights');
    }
}
