<?php

class EmployeeController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Default Home Controller
    |--------------------------------------------------------------------------
    |
    | You may wish to use controllers instead of, or in addition to, Closure
    | based routes. That's great! Here is an example controller method to
    | get you started. To route to this controller, just add the route:
    |
    |	Route::get('/', 'HomeController@showWelcome');
    |
    */
    public function ____Start____Admin____(){

    }
    public function getEmployees()
    {
        $employee_details = EmployeeModel::where('status',1)->get();
        foreach($employee_details as $employee){
            $last_record = RecordModel::where('employee_id',$employee -> employee_id)
                ->orderBy('record_id','desc')->first();
            if(!$last_record){
                $employee -> day = 99;
            }else{
                $from_date = FunctionController::numberDateToDate3($last_record -> date);
                if($last_record -> status == 2){
                    $employee -> day = "<div style='color: #ff0000'>".FunctionController::getDateDifferent($from_date,date('Y-m-d'))."</div>";
                }else{
                    $employee -> day = FunctionController::getDateDifferent($from_date,date('Y-m-d'));
                }
            }
        }
        return View::make("employee/employee")
            ->with("employee_details", $employee_details);
    }

    public function getPastEmployees()
    {

        $employee_details = EmployeeModel::where('status',0)->get();

        foreach($employee_details as $employee){
            $last_record = RecordModel::where('employee_id',$employee -> employee_id)
                ->orderBy('record_id','desc')->first();
            if(!$last_record){
                $employee -> day = 99;
            }else{
                $from_date = FunctionController::numberDateToDate3($last_record -> date);
                if($last_record -> status == 2){
                    $employee -> day = "<div style='color: #ff0000'>".FunctionController::getDateDifferent($from_date,date('Y-m-d'))."</div>";
                }else{
                    $employee -> day = FunctionController::getDateDifferent($from_date,date('Y-m-d'));
                }
            }
        }
        return View::make("employee/past_employee")
            ->with("employee_details", $employee_details);
    }


    public function getEmployeeDetail($id)
    {
        $detail = EmployeeModel::find($id);
        $detail -> role = EmployeeRoleModel::find($detail -> employee_role_id)->name;
        $detail -> payment_method = PaymentMethodModel::find($detail -> payment_method_id)->name;
        $detail -> shift = FunctionController::getShift($detail -> shift_id);
        if($detail -> location_id == 0){
            $detail -> location = 'Not Set';
        }else{
            $detail -> location = LocationModel::find($detail -> location_id)->location_name;
        }
        if($detail -> notification_valid == 0){
            $detail -> notification_valid_status = 'Not Valid';
        }else{
            $detail -> notification_valid_status = 'Valid';
        }
        $locations = LocationModel::where('status',1)->get();
        $titles = EmployeeRoleModel::all();
        return View::make("employee/detail")->with('detail',$detail)->with('locations',$locations)->with('titles',$titles);

    }

    public function addEmployee()
    {
        $employee_roles = EmployeeRoleModel::all();
        return View::make("employee/add")
            ->with('employee_roles',$employee_roles);
    }

    public function toAddEmployee()
    {
        $inputs = Input::all();
        $validator = Validator::make($inputs, EmployeeModel::$rules);

        if ($validator->fails()) {
            return Redirect::to(Request::path())->withErrors($validator)->withInput();
        }

        $employee = EmployeeModel::create($inputs);


        if ($employee->employee_id)
        {
            $employee_roles = EmployeeRoleModel::all();
            return View::make("employee/add")
                ->with('employee_roles',$employee_roles)->with('success',true);
        }
        return Response::json(array('errors'=>1,'status'=>'fail'));


    }

    public function changeEmployeePhoto($id)
    {
        $target_dir = "img/";
        $file = 'pic';

        $name = time() . basename($_FILES[$file]["name"]);
        $target_file = $target_dir . $name;
        $uploadOk = 1;
        $fileType = pathinfo($target_file, PATHINFO_EXTENSION);

// Check if file already exists
        if (file_exists($target_file)) {
            unlink($target_file);
        }
// Check file size
        if ($_FILES[$file]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
// Allow certain file formats
        if ($fileType != "jpg" && $fileType != "png") {
            echo "Sorry, only jpg or png format is allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
                $employee = EmployeeModel::find($id);
                $employee -> img = $target_file;
                $employee -> save();
                return Redirect::to('employee/detail/' . $id);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    public function addNotification($id)
    {
        $target_dir = "file/notification/";
        $file = 'pic';

        $nric = EmployeeModel::find($id) -> NRIC;

        $name = basename($_FILES[$file]["name"]);
        $target_file = $target_dir . $name;

        $uploadOk = 1;
        $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $name = $nric . '_n.'.$fileType;
        $target_file = $target_dir . $name;
// Check if file already exists
        if (file_exists($target_file)) {
            unlink($target_file);
        }
// Check file size
        if ($_FILES[$file]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
// Allow certain file formats

        if ($fileType != "pdf") {
            echo "Sorry, only pdf format is allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
                $employee = EmployeeModel::find($id);
                $employee -> notification_pdf = $target_file;
                $employee -> save();

                return Redirect::to('employee/detail/' . $id);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    public function previewNotification($id){
        $employee = EmployeeModel::find($id);
        $path = $employee -> notification;
        return Redirect::to('employee');

    }
    public function downloadNotification($id){
        $employee_id = Request::get('employee_id');
        $employee = EmployeeModel::find($employee_id);
        $employee -> status = 0;
        $employee -> save();
        return Redirect::to('employee');

    }
    public function changeToPast(){
        $employee_id = Request::get('employee_id');
        $employee = EmployeeModel::find($employee_id);
        $employee -> status = 0;
        $employee -> save();
        return Redirect::to('employee');

    }

    public function changeToCurrent(){
        $employee_id = Request::get('employee_id');
        $employee = EmployeeModel::find($employee_id);
        $employee -> status = 1;
        $employee -> save();
        return Redirect::to('employee');

    }

    public function getCards(){
        $employees = EmployeeModel::where('status',1)->get();

        return View::make("employee/card")
            ->with("employees", $employees);
    }

    public function addSecret(){
        $employee = EmployeeModel::find(Request::get('employee_id'));
        if(strlen($employee -> secret) < 6){
            $employee -> secret = str_random(6);
            $employee -> save();
        }
        return $employee -> secret;
    }
    public function check($secret){
        $id =  substr($secret,0,-6);
        $secret = substr($secret,-6);
        $employee = EmployeeModel::where('employee_id',$id)->where('secret',$secret)->first();
        return View::make("employee/check")
            ->with("employee", $employee);
    }

}
