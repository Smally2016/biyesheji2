<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MobileController extends Controller
{

    public function index()
    {
        return view('user.dashboard.dashboard');
    }

    public function checkIn()
    {


    }

    public function getRosterList()
    {
//        8023lx1994
//Smally2016
    }

    public function getReport()
    {


    }

    public function updatePassowrd()
    {
        $user = Auth::user();


    }

}
