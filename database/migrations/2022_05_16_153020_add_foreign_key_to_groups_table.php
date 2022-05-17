<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->integer('main_supervisor_id')->unsigned();
            $table->foreign('main_supervisor_id')->on('admins')->references('id')->onDelete('cascade');
            $table->integer('assistant_supervisor_id')->unsigned();
            $table->foreign('assistant_supervisor_id')->on('admins')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['main_supervisor_id', 'assistant_supervisor_id']);
        });
    }
}
