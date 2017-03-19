<?php namespace App\Http\Controllers;

class DepartmentController extends Controller
{

    public function getList()
    {
        return view('department/list');
    }

    public function createNew()
    {
        return view('department/new');
    }

}
