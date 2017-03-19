<?php namespace App\Http\Controllers;


use App\Http\Models\AttendanceModel;
use App\Http\Models\DepartmentSiteModel;
use App\Http\Models\EmployeeModel;
use App\Http\Models\ReaderModel;
use App\Http\Models\RecordModel;
use App\Http\Models\SiteModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Mockery\CountValidator\Exception;

class APIController extends Controller
{
    public function push()
    {
        $data = Request::json()->all();
        foreach ($data as $row) {
            $record = RecordModel::where($row)->first();
            if (!$record) {
                $record = new RecordModel();
                $record_id = $record->create($row)->record_id;

                $employee = EmployeeModel::where('nric', $row['nric'])->first();
                if (!$employee) {
                    $employee = new EmployeeModel();
                    $row['title_id'] = 1;
                    $row['status'] = 1;
                    $employee_id = $employee->create($row)->employee_id;
                } else {
                    $employee_id = $employee->employee_id;
                }
                $row['employee_id'] = $employee_id;
                $row['record_id'] = $record_id;

                $reader = ReaderModel::find($row['reader_id']);
                if (!$reader) {
                    $reader = new ReaderModel();
                    $reader->create(['reader_id' => $row['reader_id'], 'site_id' => 1, 'name' => 'Reader ' . $row['reader_id']])->reader_id;
                }

                $row['site_id'] = $reader->site_id;
                $department_id = $employee->departmentEmployee()->first();
                if ($department_id) {
                    $row['department_id'] = $department_id->department_id;
                    $row['status'] = 1;
                } else {
                    $row['status'] = 5;
                }
                $attendance = new AttendanceModel();
                $attendance->create($row);
            }
        }
    }

    public function getLastDate()
    {
        if (Request::get('key') == env('API_KEY')) {
            $last = RecordModel::orderBy('date_time', 'desc')->first();
            if (!$last) {
                echo json_encode([0, 0, 0]);
                die();
            } else {
                $date = Carbon::parse($last->date_time);
                echo json_encode([Carbon::yesterday()->format('Ymd'), Carbon::today()->format('Ymd'), Carbon::tomorrow()->format('Ymd')]);
            }
        }
    }

    public function insertTimeAttendance(\Illuminate\Http\Request $request)
    {
        if (!($request->has('dt') && $request->has('sid') && $request->has('ic') && $request->has('mo'))) {
            return self::present([
                'message' => 'Insufficient Parameters',
                'success' => 0,
            ]);
        }

        $dt = $request->get('dt');
        $sid = $request->get('sid');
        $ic = $request->get('ic');
        $mo = $request->get('mo');

        if (!
        (
            is_numeric($dt) && strlen($dt) == 14 &&
            is_numeric($sid) && $sid &&
            $ic &&
            is_numeric($mo) &&
            in_array($mo, [1, 2, 3, 4, 5])
        )
        ) {
            return self::present([
                'message' => 'Invalid Format of Parameters',
                'success' => 0,
            ]);
        }

        $date_time = Carbon::createFromFormat('YmdHis', $dt);
        /** @var SiteModel $site */
        $site = SiteModel::find($sid);
        /** @var EmployeeModel $employee */
        $employee = EmployeeModel::where('nric', strtoupper($ic))->first();

        if (!($date_time && $site && $employee)) {
            return self::present([
                'message' => 'Invalid Data',
                'success' => 0,
            ]);
        }

        $department_id = null;
        foreach ($employee->department as $department) {
            $department_site = DepartmentSiteModel::where([
                'department_id' => $department->department_id,
                'site_id' => $site->site_id,
            ])->first();
            if ($department_site) {
                $department_id = $department->department_id;
            }
        }

        if ($department_id == null) {
            return self::present([
                'message' => 'Employee has not assigned to the site',
                'success' => 0,
            ]);
        }

        //check existed
        $check = AttendanceModel::where([
            'employee_id' => $employee->employee_id,
            'department_id' => $department_id,
            'site_id' => $site->site_id,
            'date_time' => $date_time->format('Y-m-d H:i:s'),
            'mode' => $mo,
        ])->first();

        if ($check) {
            return self::present([
                'message' => 'Record Existed',
                'success' => 2,
            ]);
        }

        try {
            AttendanceModel::create([
                'employee_id' => $employee->employee_id,
                'department_id' => $department_id,
                'site_id' => $site->site_id,
                'date_time' => $date_time->format('Y-m-d H:i:s'),
                'status' => 1,
                'mode' => $mo,
            ]);
            return self::present([
                'message' => 'Success',
                'success' => 1,
            ]);
        } catch (Exception $e) {
            return self::present([
                'message' => 'Failed to save data.',
                'success' => 0,
            ]);
        }
    }

    public function present($data)
    {
        return response()->json(['data', $data]);
    }


}
