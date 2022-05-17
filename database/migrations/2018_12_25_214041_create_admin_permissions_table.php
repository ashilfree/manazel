<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('statistics', 10);
            $table->string('teachers', 10);
            $table->string('students', 10);
            $table->string('admins', 10);
            $table->string('countries', 10);
            $table->string('home_work', 10);
            $table->string('levels', 10);
            $table->string('audios', 10);
            $table->string('notifications', 10);
            $table->string('groups', 10);
            $table->string('settings', 10);
            $table->integer('admin_id')->unsigned()->nullable();
            $table->foreign('admin_id')->on('admins')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('admin_permissions');
    }
}
