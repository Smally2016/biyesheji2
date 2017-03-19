<?php namespace App\Http\Controllers;

use App\Http\Models\SiteModel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AdminSiteController extends Controller
{

    public function getList()
    {
        $sites = SiteModel::where('status', 1)->get();
        return view('admin/site/list')->with('sites', $sites);
    }

    public function newSite()
    {
        $success = false;
        $data = Request::all();
        if ($data) {
            $site = new SiteModel();
            $site->name = $data['name'];
            $site->status = 1;
            $site->remark = $data['remark'];
            $site->address = $data['address'];
            $site->postal = trim($data['postal']);
            $site->save();
            $success = true;
        }
        return view('admin/site/new')->with('success', $success)->with('name', $success?$data['name']:'');
    }

    public function editSite($id)
    {
        $site = SiteModel::find($id);
        $data = Request::all();
        if ($data) {
            $data['postal'] = trim($data['postal']);
            $site = SiteModel::find($data['site_id']);
            $site->update($data);
            return redirect('admin/site/list');
        }
        return view('admin/site/edit')->with('site', $site);
    }

    public function deleteSite($id)
    {
        $site = SiteModel::find($id);
        $site->departmentSite()->delete();
        $site->status = 0;
        $site->save();
        return redirect('admin/site/list');
    }

}
