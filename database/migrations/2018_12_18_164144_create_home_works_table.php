<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_works', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('arranging_homework')->unique();
            $table->string('file_path');
            $table->string('file_url');
            $table->string('file_name');
            $table->string('tajweed_link', 512)->nullable();
            $table->string('tafsir_link', 512)->nullable();
            $table->integer('level_id')->unsigned();
            $table->foreign('level_id')->on('levels')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('home_works');
    }
}
