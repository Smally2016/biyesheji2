<?php namespace App\Http\Controllers;

use App\Helpers\AttendanceHelper;
use App\Helpers\DateHelper;
use App\Http\Models\AttendanceModel;
use App\Http\Models\DepartmentEmployeeModel;
use App\Http\Models\DepartmentModel;
use App\Http\Models\EmployeeModel;
use App\Http\Models\RecordModel;
use App\Http\Models\ShiftModel;
use App\Http\Models\SiteModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Mockery\CountValidator\Exception;

class RecordController extends Controller
{

    public function getRecord()
    {
        return view('record/record');
    }

    public function edit()
    {
        $sites = SiteModel::where('status', 1)->orderBy('name', 'asc')->get();
        $departments = DepartmentModel::where('status', 1)->orderBy('name', 'asc')->get();

        $status_arr = [1, 2, 3];
        if (Request::isMethod('get')) {
            $date_range = Carbon::today()->format('d/m/Y');
            $site_id = 0;
            $department_id = 0;
        } else {
            $data = Request::all();
            $date_range = $data['date_range'];
            $site_id = $data['site_id'];
            $department_id = $data['department_id'];
            if (!isset($data['deleted_record'])) {
                $status_arr[] = 0;
            }
        }

        $date = Carbon::createFromFormat('d/m/Y', $date_range);


        $records = AttendanceModel::where('date_time', '>', $date->format('Y-m-d'))
            ->where('date_time', '<=', $date->addDay(1)->format('Y-m-d'))
            ->whereIn('status', $status_arr)
            ->orderBy('attendance_id', 'desc');

        if ($department_id != 0) {
            $records = $records->where('department_id', $department_id);
        }
        if ($site_id != 0) {
            $records = $records->where('site_id', $site_id);
        }

        $records = $records->get();

        $shifts = ShiftModel::all();
        return view('record/edit')->with([
            'date_range' => $date_range,
            'departments' => $departments,
            'sites' => $sites,
            'selected_site' => $site_id,
            'selected_department' => $department_id,
            'records' => $records,
            'shifts' => $shifts,
            'deleted_record' => isset($data) ? isset($data['deleted_record']) ? 'checked' : '' : 'checked'
        ]);
    }

    public function getReport()
    {
        $sites = SiteModel::where('status', 1)->orderBy('name', 'asc')->get();
        $departments = DepartmentModel::where('status', 1)->orderBy('name', 'asc')->get();

        $status_arr = [1, 2, 3];
        $mode_arr = [1, 2];
        if (Request::isMethod('get')) {
            $date_range = Carbon::today()->format('d/m/Y 00:00:00') . ' - ' . Carbon::today()->format('d/m/Y 23:59:59');
            $site_id = 0;
            $department_id = 0;
        } else {
            $data = Request::all();
            $date_range = $data['date_range'];
            $site_id = $data['site_id'];
            $department_id = $data['department_id'];
            if (!isset($data['status_record'])) {
                $status_arr[] = 0;
            }
            if (!isset($data['mode_record'])) {
                $mode_arr = [1, 2, 3, 4, 5];
            }
        }

        try {
            $date = explode('-', $date_range);
            $start_date = explode(' ', trim($date[0]));
            $start_date = DateHelper::dateSlashToDateDash($start_date[0]) . ' ' . $start_date[1];
            $end_date = explode(' ', trim($date[1]));
            $end_date = DateHelper::dateSlashToDateDash($end_date[0]) . ' ' . $end_date[1];

        } catch (Exception $e) {
            return redirect()->back();
        }

        $records = AttendanceModel::where('date_time', '>=', $start_date)
            ->whereIn('status', $status_arr)
            ->whereIn('mode', $mode_arr)
            ->where('date_time', '<=', $end_date)
            ->orderBy('attendance_id', 'desc');

        if ($department_id != 0) {
            $records = $records->where('department_id', $department_id);
        }
        if ($site_id != 0) {
            $records = $records->where('site_id', $site_id);
        }

        $records = $records->get();

        $shifts = ShiftModel::all();

        return view('record/report')->with([
            'departments' => $departments,
            'sites' => $sites,
            'selected_site' => $site_id,
            'selected_department' => $department_id,
            'records' => $records,
            'shifts' => $shifts,
            'date_range' => $date_range,
            'status_record' => isset($data) ? isset($data['status_record']) ? 'checked' : '' : 'checked',
            'mode_record' => isset($data) ? isset($data['mode_record']) ? 'checked' : '' : 'checked'
        ]);
    }

    public function changeDutyDate()
    {
        $data = Request::all();
        $attendance = AttendanceModel::find($data['attendance_id']);
        $attendance->duty_date = $data['duty_date'];
        if ($attendance->save()) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function changeShift()
    {
        $data = Request::all();
        $attendance = AttendanceModel::find($data['attendance_id']);
        $attendance->shift_id = $data['shift_id'];
        if ($attendance->save()) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function changeMode()
    {
        $data = Request::all();
        $attendance = AttendanceModel::find($data['attendance_id']);
        $attendance->mode = $data['mode'];
        $attendance->status = AttendanceModel::EDITED;
        if ($attendance->save()) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function getManual()
    {
        $data = Request::all();
        if ($data) {
            $data['status'] = 2;
            $data['date_time'] = explode(' ', $data['date_time']);
            $data['date_time'] = DateHelper::dateSlashToDateDash($data['date_time'][0]) . ' ' . $data['date_time'][1];
            $data['duty_date'] = DateHelper::dateSlashToDateDash($data['duty_date']);

            $data['department_id'] = EmployeeModel::find($data['employee_id'])->department->first()->department_id;
            $attendance = new AttendanceModel();
            $attendance->create($data);
            return redirect()->back();
        }
        $employees = EmployeeModel::where('status', 1)->orderBy('name', 'asc')->get();
        $departments = DepartmentModel::where('status', 1)->orderBy('name', 'asc')->get();
        $sites = SiteModel::where('status', 1)->orderBy('name', 'asc')->get();
        $shifts = ShiftModel::where('status', 1)->get();
        $records = AttendanceModel::where('status', 2)->take(100)->orderBy('attendance_id', 'desc')->get();

        return view('record/manual')->with([
            'employees' => $employees,
            'departments' => $departments,
            'sites' => $sites,
            'shifts' => $shifts,
            'records' => $records
        ]);
    }

    public function getSiteAPI()
    {
        $department_id = Request::get('department_id');
        $sites = DepartmentModel::find($department_id)->site;
        $data = array();

        foreach ($sites as $site) {
            $data[] = ['name' => $site->name, 'site_id' => $site->site_id];
        }
//
//        $id = 'name';
//        $temp_array = array();
//        while (count($data) > 0) {
//            $lowest_id = 0;
//            $index = 0;
//            foreach ($data as $item) {
//                if ($item[$id] < $data[$lowest_id][$id]) {
//                    $lowest_id = $index;
//                }
//                $index++;
//            }
//            $temp_array[] = $data[$lowest_id];
//            $array = array_merge(array_slice($data, 0, $lowest_id), array_slice($data, $lowest_id + 1));
//        }
//        echo json_encode($temp_array);
        echo json_encode($data);
    }

    public function getSiteWithEmployeeAPI()
    {
        $employee_id = Request::get('employee_id');
        $departments = EmployeeModel::find($employee_id)->department;
        $sites = array();

        foreach ($departments as $department) {
            foreach ($department->site as $site) {
                $sites[] = ['name' => $site->name, 'site_id' => $site->site_id];
            }
        }

        $sites = $this->msort($sites, 'name');
        echo json_encode($sites);
    }


    public function getShiftAPI()
    {
        $site_id = Request::get('site_id');
        $shifts = SiteModel::find($site_id)->shift;
        $result = array();
        foreach ($shifts as $shift) {
            $result[] = ['shift_id' => $shift->shift_id, 'name' => $shift->getName()];
        }

        echo json_encode($result);
    }

    public function getShiftWithEmployeeAPI()
    {
        $site_id = Request::get('site_id');
        $employee_id = Request::get('employee_id');
        $departments = [];
        foreach (DepartmentEmployeeModel::where('employee_id', $employee_id)->get() as $de) {
            $departments[] = $de->department_id;
        }
        $shifts = SiteModel::find($site_id)->shift;
        $result = array();
        foreach ($shifts as $shift) {
            if (in_array($shift->department->department_id, $departments)) {
                $result[] = ['shift_id' => $shift->shift_id, 'name' => $shift->getName() . ' ' . $shift->department->name];
            }
        }

        echo json_encode($result);
    }

    public function deleteManual($attendance_id)
    {
        $attendance = AttendanceModel::find($attendance_id);
        if ($attendance and $attendance->status == 2) {
            $attendance->status = 0;
            $attendance->save();
        }

        return redirect()->back();
    }

    public function deleteEdit()
    {
        $attendance_id = Request::get('attendance_id');
        $attendance = AttendanceModel::find($attendance_id);
        if ($attendance) {
            $attendance->status = 0;
            if ($attendance->save()) {
                echo 1;
            } else {
                echo 2;
            }
        }
    }

    function msort($array, $key, $sort_flags = SORT_REGULAR)
    {
        if (is_array($array) && count($array) > 0) {
            if (!empty($key)) {
                $mapping = array();
                foreach ($array as $k => $v) {
                    $sort_key = '';
                    if (!is_array($key)) {
                        $sort_key = $v[$key];
                    } else {
                        // @TODO This should be fixed, now it will be sorted as string
                        foreach ($key as $key_key) {
                            $sort_key .= $v[$key_key];
                        }
                        $sort_flags = SORT_STRING;
                    }
                    $mapping[$k] = $sort_key;
                }
                asort($mapping, $sort_flags);
                $sorted = array();
                foreach ($mapping as $k => $v) {
                    $sorted[] = $array[$k];
                }
                return $sorted;
            }
        }
        return $array;
    }
}
