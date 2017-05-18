<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('employee_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('title_id');
            $table->unsignedInteger('id')->nullable();
            $table->string('name');
            $table->string('nric')->unique();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('religion')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('address_postal')->nullable();
            $table->string('phone')->nullable();
            $table->string('nok')->nullable();
            $table->string('nok_phone')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('remark')->nullable();
            $table->string('account')->nullable();
            $table->string('bank')->nullable();
            $table->string('img')->nullable();
            $table->date('security_expired')->nullable();
            $table->tinyInteger('notification_valid')->nullable();
            $table->string('notification_number')->nullable();
            $table->string('notification_pdf')->nullable();
            $table->string('secret')->nullable();
            $table->date('date_joined')->nullable();
            $table->decimal('r_monthly')->nullable();
            $table->decimal('r_daily')->nullable();
            $table->decimal('r_hourly')->nullable();
            $table->decimal('r_ot')->nullable();
            $table->decimal('r_incentive')->nullable();
            $table->decimal('r_public_holiday')->nullable();
            $table->decimal('r_rest_day')->nullable();

            $table->timestamps()->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employees');
    }
}
