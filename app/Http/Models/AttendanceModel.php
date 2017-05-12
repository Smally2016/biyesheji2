<?php namespace App\Http\Models;

use Carbon\Carbon;

class AttendanceModel extends BaseModel
{

    protected $table = 'attendances';
    protected $primaryKey = 'attendance_id';

    const DELETED = 0;
    const NORMAL = 1;
    const MANUAL = 2;
    const EDITED = 3;
    const LEAVE = 4;
    const ERROR = 5;

    const MODE_IN = 1;
    const MODE_OUT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'record_id',
        'reader_id',
        'department_id',
        'site_id',
        'shift_id',
        'date_time',
        'duty_date',
        'status',
        'mode',
        'leave_type_id',
        'status',
    ];

    protected $hidden = [];

    public function employee()
    {
        return $this->belongsTo('App\Http\Models\EmployeeModel', 'employee_id', 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Http\Models\DepartmentModel', 'department_id', 'department_id');
    }

    public function site()
    {
        return $this->belongsTo('App\Http\Models\SiteModel', 'site_id', 'site_id');
    }

    public function shift()
    {
        return $this->belongsTo('App\Http\Models\ShiftModel', 'shift_id', 'shift_id');
    }

    public function roster()
    {
        return $this->HasOne('App\Http\Models\RosterModel', 'date', 'duty_date');
    }

    public function date()
    {
        return Carbon::parse($this->date_time)->format('d/m/Y');
    }

    public function time()
    {
        return Carbon::parse($this->date_time)->format('H:i:s');
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

    public function getLeave($duty_date)
    {
        $leave = AttendanceModel::where('duty_date', $duty_date)
            ->where('employee_id', $this->employee_id)
            ->where('status', 4)
            ->first();
        return $leave;
    }


    public function getShift()
    {
        $shifts = ShiftModel::where('department_id', $this->department_id)
            ->where('site_id', $this->site_id)
            ->get();
        return $shifts;
    }

    public function getStatus()
    {
        $word = '';
        switch ($this->status) {
            case 0:
                $word = 'D';
                break;
            case 2:
                $word = 'M';
                break;
            case 3:
                $word = 'E';
                break;
            case 5:
                $word = 'R';
                break;
            default:
                return;
        }
        return $word;
    }

    public function isOut()
    {
        return $this->mode == self::MODE_OUT;
    }

    public function isIn()
    {
        return $this->mode == self::MODE_IN;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function getModeTextAttribute()
    {
        return $this->getMode() == self::MODE_IN ? '上班' : '下班';
    }

    public function getDateTime()
    {
        return $this->date_time;
    }
}
