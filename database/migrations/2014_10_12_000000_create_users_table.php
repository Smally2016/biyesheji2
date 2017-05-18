<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
            $table->string('open_id');
            $table->string('username');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password', 60);
            $table->rememberToken();//记住登录 生成cookie
            $table->string('name');
            $table->string('remark')->nullable();
            $table->tinyInteger('status');
            $table->tinyInteger('is_admin');
            $table->timestamps()->default(DB::raw('CURRENT_TIMESTAMP'));//创建更新 创建
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
