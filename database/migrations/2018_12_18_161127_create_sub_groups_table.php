<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubgroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('en_name');
            $table->integer('admin_id')->unsigned()->nullable();;
            $table->foreign('admin_id')->on('users')->references('id')->onDelete('cascade');
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->on('groups')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('subgroups');
    }
}
