<?php namespace App\Http\Controllers;


use App\Http\Models\DepartmentEmployeeModel;
use App\Http\Models\DepartmentModel;
use App\Http\Models\EmployeeModel;
use App\Http\Models\ReaderModel;
use App\Http\Models\SSEmployeeModel;
use App\Http\Models\SSTitleModel;
use App\Http\Models\TitleModel;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{

    public function test()
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
        die();
        $old_employees = SSEmployeeModel::all();
        foreach ($old_employees as $old) {
            $employee = EmployeeModel::where('nric', $old->NRIC)->first();
            if ($employee) {
                $employee->notification_pdf = $old->notification_pdf;
                $employee->save();
            }


        }
        die();
        return view('test');
        $employees = EmployeeModel::all();
        foreach ($employees as $employee) {
            //$employee->citizenship = starts_with('S', $employee->citizenship)?'SC':$employee->citizenship;
            $employee->save();
        }
        die();
        $employees = EmployeeModel::all();
        foreach ($employees as $employee) {
            if ($employee->departmentEmployee->count() == 0) {
                $de = new DepartmentEmployeeModel();
                $de->department_id = 1;
                $de->employee_id = $employee->employee_id;
                $de->save();
            }
        }
        die();
        $old_employees = SSEmployeeModel::all();
        foreach ($old_employees as $old) {
            $employee = EmployeeModel::where('nric', $old->NRIC)->first();
            if ($employee) {
            } else {
                $employee = new EmployeeModel();
            }
            $employee->name = $old->name;
            if ($old->employee_role_id == 0) {
                $employee->title_id = 12;
            } else {
                $employee->title_id = $old->employee_role_id;
            }
            $employee->id = $old->virdi_id;
            $employee->nric = $old->NRIC;
            $employee->dob = $old->DOB;
            $employee->gender = $old->sex;
            $employee->nationality = $old->place_of_birth;
            $employee->citizenship = $old->citizenship;
            $employee->religion = $old->religion;
            $employee->address = $old->address . ' ' . $old->address_blk . ' ' . $old->address_unit;
            $employee->address_postal = $old->address_postal;
            $employee->phone = $old->contact;
            $employee->nok = $old->NOK;
            $employee->nok_phone = $old->NOK_contact;
            $employee->status = $old->status;
            $employee->remark = $old->remarks;
            $employee->account = $old->account;
            $employee->bank = $old->bank;
            $employee->img = $old->img;
            $employee->security_expired = $old->SecurityLicExp;
            $employee->notification_valid = $old->notification_valid;
            $employee->notification_number = $old->notification_number;
            $employee->date_joined = $old->date_joined;
            $employee->r_monthly = $old->r_monthly;
            $employee->r_daily = $old->r_daily;
            $employee->r_hourly = $old->r_hourly;
            $employee->r_ot = $old->r_ot;
            $employee->r_incentive = $old->r_incentive;
            $employee->r_public_holiday = $old->r_public_holiday;
            $employee->r_rest_day = $old->r_rest_day;
            $employee->religion = $old->religion;
            $employee->save();
        }


    }


}
