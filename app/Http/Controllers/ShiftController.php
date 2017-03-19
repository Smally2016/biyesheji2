<?php namespace App\Http\Controllers;

use App\Http\Models\DepartmentModel;
use App\Http\Models\ShiftModel;
use App\Http\Models\SiteModel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class ShiftController extends Controller
{
    public function getList()
    {
        $shifts = ShiftModel::all();
        return view('shift/list')->with('shifts', $shifts);
    }

    public function createNew()
    {
        $departments = DepartmentModel::all();
        $sites = SiteModel::where('status', 1)->orderBy('name', 'asc')->get();
        return view('shift.new')->with([
            'departments' => $departments,
            'sites' => $sites
        ]);
    }

    public function saveNew()
    {
        $data = Request::all();
        $data['status'] = 1;
        $shift = new ShiftModel();
        if ($shift->create($data)) {
            Session::flash('success', 'Created Successfully');
        }
        return redirect()->to('shift/new');
    }

    public function editShift($id)
    {
        $shift = ShiftModel::find($id);
        $departments = DepartmentModel::where('status', 1)->orderBy('name', 'asc')->get();
        $sites = SiteModel::where('status', 1)->orderBy('name', 'asc')->get();

        $data = Request::all();
        if ($data) {
            $shift = ShiftModel::find($data['shift_id']);
            $shift->update($data);
            return redirect()->to('shift/list');
        }
        return view('shift.edit')->with([
            'shift' => $shift,
            'departments' => $departments,
            'sites' => $sites
        ]);

    }
}
