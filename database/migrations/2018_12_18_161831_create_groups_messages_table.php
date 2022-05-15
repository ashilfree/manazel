<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message');
            $table->string('type');
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')->on('users')->references('id')->onDelete('cascade');
            $table->integer('sender_id')->unsigned();
            $table->integer('sub_group_id')->unsigned();
            $table->foreign('sub_group_id')->on('sub_groups')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('groups_messages');
    }
}
