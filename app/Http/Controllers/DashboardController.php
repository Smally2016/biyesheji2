<?php namespace App\Http\Controllers;

use App\Helpers\AttendanceHelper;
use App\Http\Models\AttendanceModel;
use App\Http\Models\SiteModel;

class DashboardController extends Controller
{

    public function getInout()
    {
        /** @var UserModel $user */
        $user = \Auth::user();
        if ($user->isAdmin()) {
            $records = AttendanceModel::where('status', 1)->orderBy('date_time', 'desc')->take(30)->get();
            return view('dashboard.inout')->with('records', $records);
        }
        return redirect('/m');
    }

    public function inoutAPI()
    {
        $arr = array();
        $records = AttendanceModel::orderBy('date_time', 'desc')->take(30)->get();
        foreach ($records as $record) {
            $employee_name = $record->employee->name;
            $arr[] = array(
                $record->date(),
                $record->time(),
                $record->employee->id,
                $record->employee->nric,
                $employee_name,
                !empty($record->department->name) ? $record->department->name : 'Wrong Data',
                !empty($record->site->name) ? $record->site->name : 'Wrong Data',
                AttendanceHelper::$modes[$record->mode] . ($record->getStatus() ? '(' . $record->getStatus() . ')' : ''),
            );
        }
        return json_encode(['data' => $arr]);

    }

    public function map()
    {
        $sites = SiteModel::where('status', 1)->where('lng', '>', 0)->get();
        return view('dashboard.map')->with('sites', $sites);
    }

    public static function updateGeo()
    {
        $toReturn = array();
        $toReturn['valid'] = 0;

        $sites = SiteModel::where('status', 1)->get();

        foreach ($sites as $site) {
            $num_failed = 0;
            if ($site->postal != null or $site->postal != 0) {

                try {
                    $coordinates = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=Singapore' . $site->postal . '&sensor=false');
                    $coordinates = json_decode($coordinates);
                    $coordinates = $coordinates->results[0]->geometry->location;
                    $lat = $coordinates->lat;
                    $lng = $coordinates->lng;
                    if ($lat > 2 and $lat < 0) {
                        $coordinates->results[111110];
                    }
                    if ($site->lat != $lat and $site->lng != $lng) {
                        $site->lat = $lat;
                        $site->lng = $lng;
                        $site->save();
                    }
                } catch (Exception $e) {

                    try {
                        $link = 'http://api.yyf.me/google/map/getll?postal=';
                        $coordinates = file_get_contents($link . $site->postal);
                        $coordinates = json_decode($coordinates);
                        $lat = $coordinates->lat;
                        $lng = $coordinates->lng;
                        if ($site->lat != $lat and $site->lng != $lng) {
                            $site->lat = $lat;
                            $site->lng = $lng;
                            $site->save();
                        }
                    } catch (Exception $i) {
                        $num_failed++;
                    }
                }
            }
            if ($num_failed == 0) {
                $toReturn['msg'] = 'Updated';
            } else {
                $toReturn['msg'] = $num_failed . " failed";
            }
        }
        echo json_encode($toReturn);
    }

}
