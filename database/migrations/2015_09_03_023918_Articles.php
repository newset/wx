<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Articles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->bigInteger('weixin_id');
            $table->string('url');
            $table->string('imageLink');
            $table->string('shortContent168');
            $table->string('shortContent');
            $table->text('raw');
            $table->date('date');
            $table->integer('readNum');
            $table->integer('likeNum');
            $table->dateTime('pubtime');
            $table->integer('realReadNum');
            $table->string('sn');
            $table->tinyInteger('idx');
            $table->integer('msgid');
            $table->string('srcUrl');
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
        //
    }
}
