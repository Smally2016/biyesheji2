<?php namespace App\Http\Controllers;


use App\Http\Models\ReaderModel;

class HomeController extends Controller
{

    public function index()
    {
        return view('index');
    }

    public function login()
    {
        return view('login');
    }

    public function test()
    {
        $reader = ReaderModel::first();
        print_r($reader->reader_id);
        print_r($reader->site->site_id);
        $string = $reader->site->departmentSite->first()->department_id;

        print_r($string);

    }
}
