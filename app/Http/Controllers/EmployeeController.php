<?php namespace App\Http\Controllers;

use App\Http\Models\DepartmentEmployeeModel;
use App\Http\Models\DepartmentModel;
use App\Http\Models\EmployeeModel;
use App\Http\Models\TitleModel;
use App\Http\Models\UserModel;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Helpers\NationalHelper;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    public function getList($id = null)
    {
        if ($id == null) {
            $employees = EmployeeModel::all();
        } elseif ($id == 'current') {
            $employees = EmployeeModel::where('status', 1)->get();
        } elseif ($id == 'resigned') {
            $employees = EmployeeModel::where('status', 0)->get();
        } elseif ($id == 'reconsider') {
            $employees = EmployeeModel::where('status', 2)->get();
        }
        return view('employee/list')->with(['employees' => $employees, 'id' => $id]);
    }


    public function getPast()
    {
        $employees = EmployeeModel::where('status', 0)->get();
        return view('employee/past')->with(['employees' => $employees]);
    }

    public function createNew()
    {
        $departments = DepartmentModel::where('status', 1)->get();
        $titles = TitleModel::where('status', 1)->get();
        return view('employee/new')->with([
            'departments' => $departments,
            'titles' => $titles
        ]);
    }

    public function saveNew()
    {
        $data = Request::all();
        foreach ($data as $key => $value) {
            $data[$key] = strtoupper($value);
        }
        $validator = Validator::make($data, EmployeeModel::$create_rules);
        if ($validator->fails()) {
            return Redirect::to(Request::path())->withErrors($validator)->withInput();
        }

        $data['status'] = 1;
        $data['dob'] = $data['year'] . '-' . $data['month'] . '-' . $data['day'];
        $data['name'] = strtoupper($data['name']);
        $employee = new EmployeeModel();
        if ($employee->create($data)) {
            $department_employee = new DepartmentEmployeeModel();
            $department_employee->create([
                'department_id' => $data['department_id'],
                'employee_id' => EmployeeModel::where('nric', $data['nric'])->first()->employee_id
            ]);
            Session::flash('success', 'Created Successfully');
            $phone_number = $data['phone'];
            $email = $data['email'];
            $user = UserModel::create([
                'phone' => $phone_number,
                'username' => $phone_number,
                'password' => bcrypt($phone_number),
                'email' => $email,
                'is_admin' => UserModel::EMPLOYEE,
                'status' => UserModel::STATUS_NORMAL
            ]);
            $employee->update([
                'user_id' => $user->user_id
            ]);
            return Redirect::to(Request::path());
        } else {
            Session::flash('danger', 'Created Failed.');
            return Redirect::to(Request::path())->withErrors($validator)->withInput();
        }
    }

    public function edit($employee_id)
    {
        $departments = DepartmentModel::where('status', 1)->get();
        $titles = TitleModel::where('status', 1)->get();
        $employee = EmployeeModel::find($employee_id);
        return view('employee/edit')->with([
            'departments' => $departments,
            'titles' => $titles,
            'employee' => $employee
        ]);
    }

    public function saveEdit($employee_id)
    {
        $data = Request::all();
        $employee = EmployeeModel::find($employee_id);

        if (isset($data['pdf']) or (isset($data['pic']) and $data['pic'] != '')) {
            $target_dir = "img/";
            $file = 'pic';
            $name = time() . basename($_FILES[$file]["name"]);

            $target_file = $target_dir . $name;

            $img = Image::make($_FILES[$file]['tmp_name'])->orientate();
            $img->fit(400, 514);
            $img->save($target_file);

            $employee->img = $target_file;
//            $uploadOk = 1;
//            $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
//
//            if (file_exists($target_file)) {
//                unlink($target_file);
//            }
//            if ($_FILES[$file]["size"] > 5000000) {
//                echo "Sorry, your file is too large.";
//                $uploadOk = 0;
//            }
//            if ($fileType != "jpg" && $fileType != "png") {
//                echo "Sorry, only jpg or png format is allowed.";
//                $uploadOk = 0;
//            }
//            if ($uploadOk == 0) {
//                echo "Sorry, your file was not uploaded.";
//            } else {
//                if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
//                    $employee = EmployeeModel::find($employee_id);
//                    $employee->img = $target_file;
//                    $employee->save();
//                } else {
//                    echo "Sorry, there was an error uploading your file.";
//                }
//            }
        }
        $data['dob'] = $data['year'] . '-' . $data['month'] . '-' . $data['day'];
        $data['nationality'] = strtoupper($data['nationality']);
        $data['citizenship'] = strtoupper($data['citizenship']);
        foreach ($data as $key => $value) {
            $data[$key] = strtoupper($value);
        }

        if ($employee->update($data)) {
            $de = DepartmentEmployeeModel::where('employee_id', $employee_id)->where('department_id', $data['department_id'])->first();
            if (!$de) {
                DepartmentEmployeeModel::where('employee_id', $employee_id)->delete();

                $department_employee = new DepartmentEmployeeModel();
                $department_employee->create([
                    'department_id' => $data['department_id'],
                    'employee_id' => $employee_id
                ]);

            }
            Session::flash('success', 'Updated Successfully');
        } else {
            Session::flash('danger', 'Updated failed');

        }

        return Redirect::to(Request::path());
    }

    public function saveEditPDF($employee_id)
    {
        $data = Request::all();
        $employee = EmployeeModel::find($employee_id);
        if (isset($data['pdf'])) {
            $target_dir = "file/notification/";
            $file = 'pdf';
            $name = basename($_FILES[$file]["name"]);

            $target_file = $target_dir . $name;
            $uploadOk = 1;
            $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $target_dir = "file/notification/";
            $file = 'pdf';
            $name = $employee->nric . '_n.' . $fileType;
            $target_file = $target_dir . $name;
            if (file_exists($target_file)) {
                unlink($target_file);
            }
            if ($_FILES[$file]["size"] > 5000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            if ($fileType != "jpg" && $fileType != "png") {
                echo "Sorry, only jpg or png format is allowed.";
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {

                    $employee->notification_pdf = $target_file;

                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        $employee->notification_number = $data['notification_number'];
        $employee->notification_valid = $data['notification_valid'];
        $employee->save();
        return redirect('employee/edit/' . $employee_id);
    }

    public function delete($employee_id)
    {
        $employee = EmployeeModel::find($employee_id);
        $employee->status = 0;
        $employee->save();
        return redirect('/employee/list');
    }

    public function detail($employee_id)
    {
        $employee = EmployeeModel::find($employee_id);
        return view('employee/detail')->with([
            'employee' => $employee
        ]);
    }

    public function card()
    {
        $employees = EmployeeModel::all();
        return view('employee.card')->with('employees', $employees);
    }

    public function cardDetail($secret)
    {
        $id = substr($secret, 0, -6);
        $secret = substr($secret, -6);
        $employee = EmployeeModel::where('employee_id', $id)->where('secret', $secret)->first();
        return view("employee.check")->with("employee", $employee);
    }

    public function addSecret()
    {
        $employee = EmployeeModel::find(Request::get('employee_id'));
        if (strlen($employee->secret) < 6) {
            $employee->secret = str_random(6);
            $employee->save();
        }
        return $employee->secret;
    }


}
