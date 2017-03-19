<?php namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Http\Models\AttendanceModel;
use App\Http\Models\DepartmentModel;
use App\Http\Models\EmployeeModel;
use App\Http\Models\LeaveModel;
use App\Http\Models\LeaveTypeModel;
use App\Http\Models\RosterModel;
use App\Http\Models\SiteModel;
use Illuminate\Support\Facades\Request;

class AttendanceController extends Controller
{
    public function getWeekly()
    {
        $selected_week = Request::has('week') ? Request::get('week') : null;
        if ($selected_week) {
            $selected_week = $selected_week < 10 ? '0' . $selected_week : $selected_week;
        }else{
            $selected_week = DateHelper::getCurrentWeek();
        }
        $selected_department = Request::get('department_id') ?: 0;
        $selected_site = Request::get('site_id') ?: 0;
        $selected_year = Request::get('year') ?: date('Y');
        $selected_employees = Request::get('selected_employees') ?: [];
        $start_date = date('Y-m-d', strtotime($selected_year . "-W" . $selected_week . "-" . 1));
        $end_date = date('Y-m-d', strtotime($selected_year . "-W" . $selected_week . "-" . 7));


        $departments = [];
        if ($selected_department == 0) {
            foreach (DepartmentModel::where('status', 1)->get() as $department) {
                $departments[] = $department->department_id;
            }
        } else {
            $departments[] = DepartmentModel::find($selected_department)->department_id;
        }


        $arr = array();
        //find employees who work in the week
        $employees = AttendanceModel::whereIn('status', [1, 2, 3]);

        if ($selected_department != 0) {
            $employees = $employees->where('department_id', $selected_department);
        }

        if ($selected_site != 0) {
            $employees = $employees->where('site_id', $selected_site);
        }
        if ($selected_employees) {
            $employees = $employees->whereIn('employee_id', $selected_employees);
        }
        $employees = $employees->where('duty_date', '>=', $start_date)
            ->where('duty_date', '<=', $end_date)
            ->groupBy('employee_id')
            ->get();
        foreach ($employees as $employee) {
            $arr[] = $employee->employee_id;
        }

        $employees = LeaveModel::where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->whereIn('status', [1, 2])
            ->groupBy('employee_id')
            ->get();

        foreach ($employees as $employee) {
            if (!in_array($employee->employee_id, $arr)) {
                if (in_array($employee->employee->department->first()->department_id, $departments)) {
                    if ($selected_employees and in_array($employee->employee_id, $selected_employees)) {
                        $arr[] = $employee->employee_id;
                    }
                }
            }
        }

        $employees = RosterModel::where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->whereIn('status', [1])
            ->groupBy('employee_id')
            ->get();

        foreach ($employees as $employee) {
            if (!in_array($employee->employee_id, $arr)) {
                if (in_array($employee->employee->department->first()->department_id, $departments)) {
                    if ($selected_employees and in_array($employee->employee_id, $selected_employees)) {
                        $arr[] = $employee->employee_id;
                    }
                }
            }
        }
        $employees = EmployeeModel::whereIn('employee_id', $arr)->get();

        $all_employees = EmployeeModel::where('status', 1)->orderBy('name', 'asc')->get();

        $departments = DepartmentModel::where('status', 1)->get();
        $sites = SiteModel::where('status', 1)->get();
        $leaves = LeaveTypeModel::where('status', 1)->get();
        return view('attendance.weekly')->with([
            'departments' => $departments,
            'sites' => $sites,
            'selected_year' => $selected_year,
            'selected_department' => $selected_department,
            'selected_site' => $selected_site,
            'selected_week' => $selected_week,
            'employees' => $employees,
            'all_employees' => $all_employees,
            'selected_employees' => $selected_employees,
            'leaves' => $leaves,
            'current_week' => DateHelper::getCurrentWeek()
        ]);
    }

    public function getSiteAPI()
    {
        $department_id = Request::get('department_id');
        $result = array();

        if ($department_id == 0) {
            $sites = SiteModel::where('status', 1)->orderBy('name', 'asc')->get();

            $result[] = ['site_id' => 0, 'name' => 'All Site'];
            foreach ($sites as $site) {
                $result[] = ['site_id' => $site->site_id, 'name' => $site->name];
            }
        } else {
            $department = DepartmentModel::find($department_id);
            $sites = $department->site()->orderBy('name', 'asc')->get();
            $result[] = ['site_id' => 0, 'name' => 'All Site'];
            foreach ($sites as $site) {
                $result[] = ['site_id' => $site->site_id, 'name' => $site->name];
            }
        }

        return json_encode($result);

    }


}
