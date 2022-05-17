<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_homeworks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status');
            $table->integer('home_work_id')->unsigned();
            $table->foreign('home_work_id')->on('home_works')->references('id')->onDelete('cascade');
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->on('groups')->references('id')->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('users_homeworks');
    }
}
