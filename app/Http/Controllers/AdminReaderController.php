<?php namespace App\Http\Controllers;

use App\Http\Models\ReaderModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Parser\Reader;

class AdminReaderController extends Controller
{

    public function getList()
    {
        $readers = ReaderModel::all();
        return view('admin.reader.list')->with('readers', $readers);
    }

    public function createNew()
    {
        return view('admin/reader/new');
    }

    public function saveNew()
    {
        $data = Request::all();

        $validator = Validator::make($data, ReaderModel::$create_rules);
        if ($validator->fails()) {
            return Redirect::to(Request::path())->withErrors($validator)->withInput();
        }

        $reader = new ReaderModel();
        if ($reader->create($data)) {
            Session::flash('success', 'Created Successfully');
            return Redirect::to(Request::path());
        } else {
            Session::flash('danger', 'Created Failed.');
            return Redirect::to(Request::path())->withErrors($validator)->withInput();
        }
    }

    public function editReader($id)
    {
        $reader = ReaderModel::find($id);
        $data = Request::all();
        if ($data) {
            $reader = ReaderModel::find($data['reader_id']);
            $reader->update($data);
            $success = true;
            return redirect('admin/reader/list');
        }
        return view('admin/reader/edit')->with('reader', $reader);
    }

    public function deleteReader($id)
    {
        $reader = ReaderModel::find($id);
        $reader->delete();
        return redirect('admin/reader/list');
    }

}
