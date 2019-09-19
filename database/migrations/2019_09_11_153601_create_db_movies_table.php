<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDbMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('db_movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('db_id')->default(0)->comment('豆瓣电影Id');
            $table->string('cover',255)->default('')->comment('封面链接');
            $table->string('cover_img',255)->default('')->comment('封面图片');
            $table->string('is_new',16)->default('')->comment('是否新');
            $table->string('playable',16)->default('')->comment('是否可播');
            $table->string('rate',8)->default('')->comment('打分');
            $table->string('title',32)->default('')->comment('标题');
            $table->string('url',255)->default('')->comment('链接');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('db_movies');
    }
}
