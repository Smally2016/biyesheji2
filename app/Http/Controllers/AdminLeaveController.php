<?php namespace App\Http\Controllers;

use App\Http\Models\LeaveTypeModel;
use Illuminate\Support\Facades\Request;

class AdminLeaveController extends Controller
{

    public function getLeaveType()
    {
        $leaves = LeaveTypeModel::where('status', 1)->get();
        return view('admin/leave/list')->with('leaves', $leaves);
    }

    public function newLeaveType()
    {
        $success = false;
        $name = Request::get('name');
        $remark = Request::get('remark');
        if ($name) {
            $leave = new LeaveTypeModel();
            $leave->name = $name;
            $leave->status = 1;
            $leave->remark = $remark;
            $leave->save();
            $success = true;
        }
        return view('admin/leave/new')->with('success', $success)->with('name', $name);
    }

    public function editLeaveType($id)
    {
        $leave = LeaveTypeModel::find($id);
        $name = Request::get('name');
        $leave_type_id = Request::get('leave_type_id');
        $remark = Request::get('remark');

        if ($name and $leave_type_id) {
            $leave = LeaveTypeModel::find($leave_type_id);
            $leave->name = $name;
            $leave->remark = $remark;
            $leave->save();
            return redirect('admin/leave/type/list');
        }
        return view('admin/leave/edit')->with('leave', $leave);
    }

    public function deleteLeaveType($id)
    {
        $leave = LeaveTypeModel::find($id);
        $leave->status = 0;
        $leave->save();
        return redirect('admin/leave/type/list');
    }
}
