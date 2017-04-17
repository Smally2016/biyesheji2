<?php

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
            $table->increments('user_id');
            $table->string('username');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password', 60);
            $table->rememberToken();
            $table->string('name');
            $table->string('remark')->nullable();
            $table->tinyInteger('status');
            $table->tinyInteger('is_admin');
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
        Schema::drop('users');
    }
}
