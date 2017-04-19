<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rosters = \App\Http\Models\RosterModel::all();
        foreach ($rosters as $roster) {
            $employee_id = $roster->employee_id;
            /** @var \App\Http\Models\EmployeeModel $employee */
            $employee = \App\Http\Models\EmployeeModel::find($employee_id);

            $shift_id = $roster->shift_id;
            /** @var \App\Http\Models\ShiftModel $shift */
            $shift = \App\Http\Models\ShiftModel::find($shift_id);

            /** @var \App\Http\Models\DepartmentModel $department */
            $department = $shift->department;
            $department_id = $department->department_id;
            /** @var \App\Http\Models\SiteModel $site */
            $site = $shift->site;
            $site_id = $site->site_id;

            $date = $roster->date;

            $start_time = $date . ' ' . $shift->start_time;
            $start_time = \Carbon\Carbon::parse($start_time)->addMinute(rand(-30, 20));
            $end_time = \Carbon\Carbon::parse($start_time)->addHour($shift->hour)->addMinute(rand(-30, 20));
            \App\Http\Models\AttendanceModel::create([
                'employee_id' => $employee_id,
                'shift_id' => $shift_id,
                'department_id' => $department_id,
                'site_id' => $site_id,
                'date_time' => $start_time->toDateTimeString(),
                'duty_date' => $date,
                'status' => 1,
                'mode' => \App\Http\Models\AttendanceModel::MODE_IN,
            ]);

            \App\Http\Models\AttendanceModel::create([
                'employee_id' => $employee_id,
                'shift_id' => $shift_id,
                'department_id' => $department_id,
                'site_id' => $site_id,
                'date_time' => $end_time->toDateTimeString(),
                'duty_date' => $date,
                'status' => 1,
                'mode' => \App\Http\Models\AttendanceModel::MODE_IN,
            ]);
        }
    }
}