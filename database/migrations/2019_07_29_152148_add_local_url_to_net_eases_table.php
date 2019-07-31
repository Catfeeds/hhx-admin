<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocalUrlToNetEasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('net_eases', function (Blueprint $table) {
            $table->string('localUrl',255)->default('')->comment('本地链接地址');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('net_eases', function (Blueprint $table) {
            //
        });
    }
}
