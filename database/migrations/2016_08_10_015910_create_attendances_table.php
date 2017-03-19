<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->increments('attendance_id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('shift_id')->default(0);
            $table->unsignedInteger('record_id')->default(0);
            $table->unsignedInteger('reader_id')->default(0);
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('site_id');
            $table->dateTime('date_time');
            $table->date('duty_date')->default('0000-00-00');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('mode');
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
        Schema::drop('attendances');
    }
}
