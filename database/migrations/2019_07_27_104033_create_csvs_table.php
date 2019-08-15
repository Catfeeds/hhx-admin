<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csvs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file',255)->default('')->comment('csv文件地址');
            $table->smallInteger('status')->default(0)->comment('状态 0未同步1同步');
            $table->smallInteger('type')->default(0)->comment('类型 0为网易云');
            $table->integer('count')->default(0)->comment('个数');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `csvs` comment 'csv文件'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('csvs');
    }
}
