<?php namespace App\Http\Controllers;

use App\Http\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function getList()
    {
        return view('user/list');
    }

    public function createNew()
    {
        return view('user/new');
    }

    public function login()
    {
        return view('login')->with('message', 'Sign in to start your session');

    }

    public function doLogin()
    {
        $data = [
            'username' => Request::get('username'),
            'password' => Request::get('password')
        ];
        if (Auth::attempt($data, true)) {
            /** @var UserModel $user */
            $user = \Auth::user();
            if ($user->isAdmin()) {
                return redirect('/');
            }
            return redirect('/m');
        } else {
            return redirect('login')->with('message', 'Username / Password is not correct.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('login');

    }
}
