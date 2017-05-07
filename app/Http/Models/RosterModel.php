<?php namespace App\Http\Models;

class RosterModel extends BaseModel {

	protected $table = 'rosters';
    protected $primaryKey = 'roster_id';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['employee_id','shift_id','date','status','leave_type_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];


	public function employee()
	{
		return $this->belongsTo('App\Http\Models\EmployeeModel','employee_id','employee_id');
	}

	public function shift()
	{
		return $this->belongsTo('App\Http\Models\ShiftModel','shift_id','shift_id');
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

	public function getDate()
    {
        return $this->date;
	}
}
