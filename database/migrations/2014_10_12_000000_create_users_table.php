<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('birthday');
            $table->integer('quran_parts');
            $table->string('spare_time')->nullable();;
            $table->string('workـhours')->nullable();;
            $table->string('type');
            $table->integer('level_id')->unsigned()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('lang')->nullable();
            $table->smallInteger('mogazh')->default(0)->nullable();
            $table->integer('mastery_certificates')->default(0)->nullable();
            $table->string('push_token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
