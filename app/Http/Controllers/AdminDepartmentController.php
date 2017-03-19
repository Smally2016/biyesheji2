<?php namespace App\Http\Controllers;

use App\Http\Models\DepartmentModel;
use App\Http\Models\DepartmentSiteModel;
use App\Http\Models\DepartmentUserModel;
use App\Http\Models\SiteModel;
use App\Http\Models\UserModel;
use Illuminate\Support\Facades\Request;

class AdminDepartmentController extends Controller
{

    public function getDepartment()
    {
        $departments = DepartmentModel::where('status', 1)->get();
        return view('admin.department.list')->with(['departments' => $departments]);
    }

    public function newDepartment()
    {
        $success = false;
        $name = Request::get('name');
        $remark = Request::get('remark');
        if ($name) {
            $department = new DepartmentModel();
            $department->name = $name;
            $department->status = 1;
            $department->remark = $remark;
            $department->save();
            $success = true;
        }
        return view('admin.department.new')->with('success', $success)->with('name', $name);
    }

    public function editDepartment($id)
    {
        $department = DepartmentModel::find($id);
        $data = Request::all();
        if ($data) {
            $department = DepartmentModel::find($data['department_id']);
            $department->update($data);
            return redirect('admin/department/list');
        }
        return view('admin.department.edit')->with('department', $department);
    }

    public function deleteDepartment($id)
    {
        $department = DepartmentModel::find($id);
        $department->status = 0;
        $department->save();
        return redirect('admin/department/list');
    }

    public function manageDepartment($id)
    {
        $department = DepartmentModel::find($id);
        $ds = DepartmentSiteModel::where('department_id', $id)->get(array('site_id'))->toArray();
        $sites = SiteModel::whereNotIn('site_id', $ds)->where('status', 1)->get();

        return view('admin.department.manage_site')->with('department', $department)->with('sites', $sites);
    }

    public function newDepartmentSite()
    {
        $data = Request::all();
        $departmentSite = new DepartmentSiteModel();
        $departmentSite->create($data);
        return redirect()->back();
    }

    public function deleteDepartmentSite($department_id, $site_id)
    {
        DepartmentSiteModel::where('department_id', $department_id)->where('site_id', $site_id)->delete();
        return redirect()->back();
    }

    public function manageUser($id)
    {
        /** @var DepartmentModel $department */
        $department = DepartmentModel::find($id);
        $department_user_ids = $department->users()->get(['department_user.user_id']);
        $exclude_user_ids = [];
        foreach ($department_user_ids as $id) {
            $exclude_user_ids[] = $id->user_id;
        }
        $users = UserModel::whereNotIn('user_id', $exclude_user_ids)->get();

        return view('admin.department.manage_user', [
            'department' => $department,
            'users' => $users,
        ]);
    }

    public function newDepartmentUser()
    {
        $data = Request::all();
        DepartmentUserModel::create($data);
        return redirect()->back();
    }

    public function deleteDepartmentUser($department_id, $user_id)
    {
        $user = DepartmentUserModel::where([
            'department_id' => $department_id,
            'user_id' => $user_id
        ])->delete();
        return redirect()->back();
    }
}
