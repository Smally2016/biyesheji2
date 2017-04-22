<?php namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Http\Models\AttendanceModel;
use App\Http\Models\DepartmentModel;
use App\Http\Models\EmployeeModel;
use App\Http\Models\LeaveModel;
use App\Http\Models\LeaveTypeModel;
use App\Http\Models\RosterModel;
use App\Http\Models\ShiftModel;
use App\Http\Models\SiteModel;
use App\Http\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class MobileController extends Controller
{

    public function index()
    {
        /** @var UserModel $user */
        $user = \Auth::user();
        /** @var EmployeeModel $employee */
        $employee = $user->employee;

        $rosters = $employee->rosters()->with('shift')->where([
            'date' => ['>', Carbon::now()->format('Y-m-d')]
        ])->take(3)->get();

        /** @var AttendanceModel $last_check */
        $last_check = $employee->attendances()->orderBy('attendance_id', 'desc')->first();
        $current_check = $last_check ? $last_check->date_time : '';

        $in_out = '';
        if ($last_check->isIn()) {
            $in_out = '上班';
        }
        if ($last_check->isOut()) {
            $in_out = '下班';
        }


        $working_time = '未开始工作';
        if ($last_check && $last_check->isIn()) {
            /** @var ShiftModel $shift */
            $shift = $last_check->shift;
            $working_time = Carbon::parse($current_check)
                ->addHour($shift->getHour())
                ->addMinute($shift->getMinute())
                ->diffInMinutes(Carbon::parse($current_check));
            $working_time = round($working_time / 60) . '小时' . ($working_time % 60) . '分';

        }
        return view('user.dashboard.dashboard', [
            'user' => $user,
            'rosters' => $rosters,
            'current_check' => $current_check,
            'in_out' => $in_out,
            'working_time' => $working_time,
        ]);
    }

    public function checkIn()
    {


    }

    public function getRosterList()
    {
        //Smally2016
        /** @var UserModel $user */
        $user = \Auth::user();
        /** @var EmployeeModel $employee */
        $employee = $user->employee;

        $rosters = $employee->rosters()->with('shift')->orderBy('roster_id', 'desc')->paginate();
        return view('user.roster.roster', [
            'rosters' => $rosters
        ]);
    }

    public function getReport()
    {
        /** @var UserModel $user */
        $user = \Auth::user();
        /** @var EmployeeModel $employee */
        $employee = $user->employee;
        $employee_id = $employee->employee_id;

        $selected_week = Request::has('week') ? Request::get('week') : null;
        if ($selected_week) {
            $selected_week = $selected_week < 10 ? '0' . $selected_week : $selected_week;
        } else {
            $selected_week = DateHelper::getCurrentWeek();
        }
        $selected_department = Request::get('department_id') ?: 0;
        $selected_site = Request::get('site_id') ?: 0;
        $selected_year = Request::get('year') ?: date('Y');
        $selected_employees = [$employee_id];
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
        $employees = EmployeeModel::where([
            'employee_id' => $employee_id
        ])->whereIn('employee_id', $arr)->get();

        $all_employees = EmployeeModel::where('status', 1)->orderBy('name', 'asc')->get();

        $departments = DepartmentModel::where('status', 1)->get();
        $sites = SiteModel::where('status', 1)->get();
        $leaves = LeaveTypeModel::where('status', 1)->get();
        return view('user.report.report')->with([
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
            'current_week' => DateHelper::getCurrentWeek(),
            'employee' => $employee,
        ]);
    }

    public function getAttendance()
    {
        /** @var UserModel $user */
        $user = \Auth::user();
        /** @var EmployeeModel $employee */
        $employee = $user->employee;

        $attendances = $employee->attendances()->orderBy('attendance_id', 'desc')->paginate();
        return view('user.attendance.attendance', [
            'attendances' => $attendances,
        ]);
    }

    public function updatePassowrd()
    {
        $user = Auth::user();


    }

    public function getProfile()
    {
        /** @var UserModel $user */
        $user = \Auth::user();
        /** @var EmployeeModel $employee */
        $employee = $user->employee;
        return view('user.profile.profile', [
            'user' => $user,
            'employee' => $employee,
        ]);
    }

}
