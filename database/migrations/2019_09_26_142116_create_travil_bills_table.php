<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravilBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travil_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('direction_id')->default(0)->comment('方向Id');
            $table->integer('hhx_travil_id')->default(0)->comment('旅行Id');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `travil_bills` comment '旅行账单'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travil_bills');
    }
}
