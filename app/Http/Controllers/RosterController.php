<?php namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Http\Models\DepartmentModel;
use App\Http\Models\EmployeeModel;
use App\Http\Models\LeaveModel;
use App\Http\Models\LeaveTypeModel;
use App\Http\Models\RosterModel;
use App\Http\Models\SiteModel;
use Illuminate\Support\Facades\Request;

class RosterController extends Controller
{
    public function getRoster()
    {
        $data = Request::all();
        if ($data) {
            $selected_year = $data['year'];
            $selected_week = $data['week'] < 10 ? '0' . $data['week'] : $data['week'];
            $selected_site = $data['site_id'];
            $site = SiteModel::find($selected_site);
        } else {
            $selected_year = date('Y');
            $selected_week = DateHelper::getCurrentWeek();
            $site = SiteModel::first();
        }
        $shifts = $site->shift ?? [];
        $start_date = \Carbon\Carbon::parse(date('Y-m-d', strtotime($selected_year . "-W" . $selected_week . "-" . 1)));
        $end_date = \Carbon\Carbon::parse(date('Y-m-d', strtotime($selected_year . "-W" . $selected_week . "-" . 7)));
        foreach ($shifts as $shift) {
            $employees = RosterModel::where('date', '>=', $start_date->format('Y-m-d'))
                ->where('date', '<=', $end_date->format('Y-m-d'))
                ->where('shift_id', $shift->shift_id)
                ->where('status', 1)
                ->groupBy('employee_id')
                ->get();

            foreach ($employees as $employee) {
                $rosters = RosterModel::where('date', '>=', $start_date->format('Y-m-d'))
                    ->where('date', '<=', $end_date->format('Y-m-d'))
                    ->where('shift_id', $shift->shift_id)
                    ->where('employee_id', $employee->employee_id)
                    ->where('status', 1)
                    ->get();
                $employee->rosters = $rosters;

                $leaves = LeaveModel::where('date', '>=', $start_date->format('Y-m-d'))
                    ->where('date', '<=', $end_date->format('Y-m-d'))
                    ->where('employee_id', $employee->employee_id)
                    ->where('status', '>', 0)
                    ->get();
                $employee->leaves = $leaves;
            }
            $shift->employees = $employees;

        }

        $sites = SiteModel::where('status', 1)->orderBy('name', 'asc')->get();
//        $employees = array();
//        foreach ($site->department as $department) {
//            foreach ($department->employee as $employee) {
//                if($employee->status == 1){
//                    $employees[] = array(
//                        'employee_id' => $employee->employee_id,
//                        'name' => $employee->name,
//                        'nric' => $employee->nric,
//                    );
//                }
//            }
//        }

        $leave_types = LeaveTypeModel::where('status', 1)->get();
        return view('roster.roster')->with([
            'selected_year' => $selected_year,
            'selected_week' => $selected_week,
            'selected_site' => $site->site_id ?? 0,
            'sites' => $sites,
            'shifts' => $shifts,
//            'employees' => $employees,
            'leave_types' => $leave_types,
            'current_week' => DateHelper::getCurrentWeek()
        ]);
    }

    public function addEmployee()
    {
        $data = Request::all();
        $date = \Carbon\Carbon::parse(date('Y-m-d', strtotime($data['year'] . "-W" . $data['week'] . "-" . 1)))->addDay(-1);
        for ($i = 0; $i < 7; $i++) {
            $date->addDay(1);
            $roster = RosterModel::where('employee_id', $data['employee_id'])
                ->where('shift_id', $data['shift_id'])
                ->where('date', $date->format('Y-m-d'))
                ->where('status', 1)
                ->first();
            if (!$roster) {
                $roster = new RosterModel();
                $roster->employee_id = $data['employee_id'];
                $roster->shift_id = $data['shift_id'];
                $roster->date = $date->format('Y-m-d');
                $roster->status = 1;
                $roster->save();
            }
        }
        return redirect()->back();
    }

    public function deleteWork()
    {
        $data = Request::all();
        $roster = RosterModel::where('shift_id', $data['shift_id'])
            ->where('employee_id', $data['employee_id'])
            ->where('date', $data['date'])
            ->where('status', 1)
            ->first();
        if ($roster) {
            $roster->status = 0;
            $roster->save();
            echo 1;
        } else {
            echo 2;
        }
    }

    public function deleteLeave()
    {
        $data = Request::all();
        $leave = LeaveModel::where('employee_id', $data['employee_id'])
            ->where('date', $data['date'])
            ->where('status', '>', 0)
            ->first();
        if ($leave) {
            $leave->status = 0;
            $leave->save();
            echo 1;
        } else {
            echo 2;
        }
    }

    public function addWorkOrLeave()
    {
        $data = Request::all();
        if ($data['type'] == 'work') {
            $roster = RosterModel::where('shift_id', $data['shift_id'])
                ->where('employee_id', $data['employee_id'])
                ->where('date', $data['date'])
                ->where('status', 1)
                ->first();
            if (!$roster) {
                $roster = new RosterModel();
                $roster->employee_id = $data['employee_id'];
                $roster->shift_id = $data['shift_id'];
                $roster->date = $data['date'];
                $roster->status = 1;
                $roster->save();
            }
        } else {
            $leave = LeaveModel::where('employee_id', $data['employee_id'])
                ->where('date', $data['date'])
                ->where('status', '>', 0)
                ->first();
            if (!$leave) {
                $leave = new LeaveModel();
                $leave->employee_id = $data['employee_id'];
                $leave->date = $data['date'];
                $leave->type_id = $data['type_id'];
                $leave->leave_type_id = $data['leave_type_id'];
                $leave->status = 1;
                $leave->remark = $data['remark'];
                $leave->save();
            }
        }


        return redirect()->back();
    }
}
