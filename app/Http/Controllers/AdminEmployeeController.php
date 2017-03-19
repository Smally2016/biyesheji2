<?php namespace App\Http\Controllers;

use App\Http\Models\TitleModel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AdminEmployeeController extends Controller
{
    public function newEmployeeTitle()
    {
        $success = false;
        $name = Request::get('name');
        $remark = Request::get('remark');
        if ($name) {
            $leave = new TitleModel();
            $leave->name = $name;
            $leave->status = 1;
            $leave->remark = $remark;
            $leave->save();
            $success = true;
        }
        return view('admin.employee.new')->with('success', $success)->with('name', $name);
    }

    public function getTitle()
    {
        $titles = TitleModel::where('status', 1)->get();
        return view('admin.employee.list')->with('titles', $titles);
    }

    public function editEmployeeTitle($id)
    {
        $title = TitleModel::find($id);
        $name = Request::get('name');
        $title_id = Request::get('title_id');
        $remark = Request::get('remark');

        if ($name and $title_id) {
            $title = TitleModel::find($title_id);
            $title->name = $name;
            $title->remark = $remark;
            $title->save();
            $success = true;
            return redirect('admin/employee/title/list');
        }
        return view('admin.employee.edit')->with('title', $title);
    }

    public function deleteEmployeeTitle($id)
    {
        $title = TitleModel::find($id);
        $title->status = 0;
        $title->save();
        return redirect('admin/employee/title/list');
    }
}
