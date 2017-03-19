<?php namespace App\Http\Controllers;


use App\Helpers\DateHelper;
use Illuminate\Support\Facades\Request;

class WebAPIController extends Controller
{
    public function getWeeks()
    {
        $year = Request::get('year');
        $current_week = DateHelper::getCurrentWeek();
        $total_week = DateHelper::getWeeks();
        $arr = array();
        for ($i = 1; $i <= $total_week; $i++) {
            if ($i < 10) {
                $week = '0' . $i;
            } else {
                $week = $i;
            }
            $monday = date('d/m/Y', strtotime($year . "-W" . $week . "-1"));
            $sunday = date('d/m/Y', strtotime($year . "-W" . $week . "-7"));
            $arr[$i]['week_number'] = $i;
            $arr[$i]['monday'] = $monday;
            $arr[$i]['sunday'] = $sunday;
            if ($i == $current_week) {
                $arr[$i]['current'] = true;
            } else {
                $arr[$i]['current'] = false;
            }
        }
        echo json_encode($arr);


    }

}
