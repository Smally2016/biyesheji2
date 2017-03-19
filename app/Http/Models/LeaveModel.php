<?php namespace App\Http\Models;

class LeaveModel extends BaseModel
{

    protected $table = 'leaves';
    protected $primaryKey = 'leave_id';

    protected $fillable = ['employee_id', 'leave_type_id', 'type_id', 'status', 'remark'];


    protected $hidden = [];

    const FULL_DAY = 0;
    const AM = 1;
    const PM = 2;

    public static $types = array(
        0 => 'F.D.',
        1 => 'AM',
        2 => 'PM'
    );

    public static $types_full = array(
        0 => 'F.D. (Full Day)',
        1 => 'AM',
        2 => 'PM'
    );
    public function employee()
    {
        return $this->belongsTo('App\Http\Models\EmployeeModel', 'employee_id', 'employee_id');
    }

    public function leaveType()
    {
        return $this->belongsTo('App\Http\Models\LeaveTypeModel', 'leave_type_id', 'leave_type_id');
    }

    public function getAllSite($duty_date)
    {
        $sites = AttendanceModel::where('duty_date', $duty_date)
            ->where('shift_id', '!=', 0)
            ->where('employee_id', $this->employee_id)
            ->whereIn('status', [1, 2, 3])
            ->orderBy('date_time', 'asc')
            ->groupBy('site_id')
            ->get(array('site_id'));
        return $sites;
    }

    public function getAllShift($site_id, $duty_date)
    {
        $shift_id = AttendanceModel::where('duty_date', $duty_date)
            ->where('shift_id', '!=', 0)
            ->where('site_id', $site_id)
            ->where('employee_id', $this->employee_id)
            ->whereIn('status', [1, 2, 3])
            ->orderBy('date_time', 'asc')
            ->groupBy('shift_id')
            ->get(array('shift_id'));
        return $shift_id;
    }

    public function getAttendance($site_id, $shift_id, $duty_date)
    {
        $result = array();
        $in = AttendanceModel::where('duty_date', $duty_date)
            ->where('site_id', $site_id)
            ->where('shift_id', $shift_id)
            ->where('shift_id', '!=', 0)
            ->where('employee_id', $this->employee_id)
            ->whereIn('status', [1, 2, 3])
            ->where('mode', 1)
            ->orderBy('date_time', 'asc')
            ->first();

        $out = AttendanceModel::where('duty_date', $duty_date)
            ->where('site_id', $site_id)
            ->where('shift_id', $shift_id)
            ->where('shift_id', '!=', 0)
            ->where('employee_id', $this->employee_id)
            ->whereIn('status', [1, 2, 3])
            ->where('mode', 2)
            ->orderBy('date_time', 'desc')
            ->first();
        if ($in or $out) {
            $result[] = array(
                'in' => $in,
                'out' => $out
            );

        }

        return $result;
    }
}
