<?php namespace App\Http\Models;

class EmployeeModel extends BaseModel
{

    protected $table = 'employees';
    protected $primaryKey = 'employee_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'id',
        'title_id',
        'nric',
        'dob',
        'gender',
        'nationality',
        'citizenship',
        'address',
        'address_postal',
        'email',
        'phone',
        'nok',
        'nok_phone',
        'status',
        'bank',
        'account',
        'remark'
    ];

    const RESIGN = 0;
    const CURRENT = 1;
    const CONSIDER = 2;

    const BANK_POSB = 'POSB';
    const BANK_DBS = 'DBS';
    const BANK_OCBC = 'OCBC';
    const BANK_UOB = 'UOB';

    public static $status = array(
        0 => 'Resigned',
        1 => 'Current',
        2 => 'Re-Consider'
    );
    public static $banks = [
        self::BANK_POSB,
        self::BANK_DBS,
        self::BANK_OCBC,
        self::BANK_UOB
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public static $create_rules = array(
        'nric' => 'required|min:8|unique:employees,nric',
        'name' => 'required',
    );

    public function department()
    {
        return $this->belongsToMany(
            'App\Http\Models\DepartmentModel',
            'department_employee',
            'employee_id',
            'department_id'
        );
    }

    public function departmentEmployee()
    {
        return $this->hasMany('App\Http\Models\DepartmentEmployeeModel', 'employee_id', 'employee_id');
    }

    public function title()
    {
        return $this->belongsTo('App\Http\Models\TitleModel', 'title_id', 'title_id');
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
