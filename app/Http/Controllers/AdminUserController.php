<?php namespace App\Http\Controllers;

use App\Http\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    public function getList()
    {
        $users = UserModel::orderBy('is_admin', 'desc')->get();
        return view('admin/user/list')->with(['users' => $users]);
    }

    public function createNew()
    {
        return view('admin/user/new');
    }

    public function saveNew()
    {
        $data = Request::all();
        $validator = Validator::make($data, UserModel::$create_rules);
        if ($validator->fails()) {
            return Redirect::to(Request::path())->withErrors($validator)->withInput();
        }
        if ($data['password'] != $data['confirm_password']) {
            Session::flash('danger', 'Password Not Match.');
        }
        $data['password'] = Hash::make($data['password']);
        $data['status'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        if (isset($data['admin']) and $data['admin'] == 'on') {
            $data['is_admin'] = 1;
        } else {
            $data['is_admin'] = 0;
        }
        $user = new UserModel();
        if ($user->create($data)) {
            Session::flash('success', 'Created Successfully');
            return Redirect::to(Request::path());
        } else {
            Session::flash('danger', 'Created Failed.');
            return Redirect::to(Request::path())->withErrors($validator)->withInput();
        }

    }

    public function edit($user_id)
    {
        $data = Request::all();
        if ($data) {
            $data = Request::all();
            /** @var UserModel $user */
            $user = UserModel::find($user_id);
       
            if ($data['password'] != '') {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            $user->update($data);
            return redirect('admin/user/list');
        } else {
            $user = UserModel::find($user_id);
            return view('admin/user/edit')->with(['user' => $user]);
        }
    }

}
