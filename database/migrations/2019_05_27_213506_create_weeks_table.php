<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weeks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('week_name');
            $table->string('week_en_name');
            $table->integer('week_number')->unique();
            $table->string('homework_file_path');
            $table->string('homework_file_url');
            $table->string('homework_file_name');
            $table->string('tajweed_link', 512)->nullable();
            $table->string('tafsir_link', 512)->nullable();
            $table->integer('sub_level_id')->unsigned();
            $table->foreign('sub_level_id')->on('sub_levels')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('weeks');
    }
}
