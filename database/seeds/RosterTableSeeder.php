<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RosterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date_arr = [];
        $start_date = \Carbon\Carbon::createFromFormat('Y-m-d', '2017-01-01');
        for ($i = $start_date; $i->lte(\Carbon\Carbon::now()->addDay(30)); $i->addDay()) {
            if($i->isWeekday()){
                $date_arr[] = $i->format('Y-m-d');
            }
        }


        $employees = \App\Http\Models\EmployeeModel::all();
        /** @var \App\Http\Models\EmployeeModel $employee */
        foreach ($employees as $employee) {
            foreach ($date_arr as $date) {
                /** @var \App\Http\Models\DepartmentModel $department */
                $department = $employee->department()->first();
                $shift = $department->shifts()->first();
                $employee->rosters()->create([
                    'shift_id' => $shift->shift_id,
                    'date' => $date,
                    'status' => 1,
                ]);
            }
        }
    }
}
