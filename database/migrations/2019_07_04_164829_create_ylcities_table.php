<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYlcitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ylcities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('CITYJX', 16);
            $table->string('CITYNAME', 32);
            $table->string('DISTRICTID', 32);
            $table->string('PRODUCTNUM', 32);
        });
        \Illuminate\Support\Facades\DB::statement("alter table `ylcities` comment'永乐城市表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ylcities');
    }
}
