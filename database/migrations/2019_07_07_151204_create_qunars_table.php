<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQunarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qunars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('airCode', 16)->comment("代码");
            $table->string('arrAirport', 32)->comment("抵达机场");
            $table->string('arrAirportCode', 16)->comment("抵达机场代码");
            $table->string('arrDate', 16)->comment("抵达日期");
            $table->string('arrTerminal', 8)->comment("抵达航站楼");
            $table->string('arrTime', 8)->comment("抵达时间");
            $table->string('crossDayDesc', 8)->comment("隔天");
            $table->string('depDate', 16)->comment("出发日期");
            $table->string('depAirport', 32)->comment("出发机场");
            $table->string('depAirportCode', 16)->comment("出发机场代码");
            $table->string('depTerminal', 8)->comment("出发航站楼");
            $table->string('depTime', 8)->comment("出发时间");
            $table->string('distance',16 )->comment("里程");
            $table->string('flightTime', 16)->comment("飞行时间");
            $table->string('fullName',32)->comment("航空公司");
            $table->smallInteger('meal')->comment("是否有餐食");
            $table->string('piaoShao',32 )->comment("piaoShao");
            $table->string('planeFullType', 32)->comment("飞机型号");
            $table->string('shortCarrier', 8)->comment("航空公司简称");
            $table->string('discountStr', 8)->comment("折扣");
            $table->string('minPrice', 8)->comment("最低价格");
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `qunars` comment '去哪儿网数据'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qunars');
    }
}
