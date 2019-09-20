<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToDoListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('to_do_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',16)->default('')->comment('标题');
            $table->string('desc',255)->default('')->comment('详情');
            $table->smallInteger('status')->default(0)->comment('状态0未完成1完成');
            $table->timestamp('good_date')->comment('最好完成时间');
            $table->smallInteger('comment')->default(0)->comment('0未定义1按时完成2延长时间');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE `flights` comment '待办事项'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('to_do_lists');
    }
}
