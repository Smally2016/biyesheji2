<?php namespace App\Http\Controllers;

class AdminDeviceController extends Controller
{

    public function getAll()
    {

        return view('admin.device.all');
    }

    public function createNew()
    {
        return view('admin.device.new');
    }

}
