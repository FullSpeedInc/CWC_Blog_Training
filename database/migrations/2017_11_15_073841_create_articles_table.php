<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
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
            $table->dateTime('deleted_at')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('contents');
            $table->string('image_path')->nullable();
            $table->timestamps();
            $table->integer('updated_user_id')->length(10)->unsigned();
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->integer('article_category_id')->length(10)->unsigned();
            $table->foreign('article_category_id')->references('id')->on('article_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
