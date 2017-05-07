<?php namespace App\Http\Models;

use Carbon\Carbon;

class ShiftModel extends BaseModel
{

    const STATUS_DELETED = 0;
    const STATUS_NORMAL = 1;

    protected $table = 'shifts';
    protected $primaryKey = 'shift_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['department_id', 'site_id', 'start_time', 'hour', 'minute', 'status', 'remark'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function site()
    {
        return $this->belongsTo('App\Http\Models\SiteModel', 'site_id', 'site_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Http\Models\DepartmentModel', 'department_id', 'department_id');
    }

    public function getName()
    {
        $start = Carbon::parse($this->start_time)->format('H:i');;
        $end = Carbon::parse($this->start_time)->addHour($this->hour)->addMinute($this->minute)->format('H:i');
        return $start . '-' . $end;
    }

    public function getEndTime()
    {
        return Carbon::parse($this->start_time)->addHour($this->hour)->addMinute($this->minute);
    }

    public function getEndTimeAttribute()
    {
        return $this->getEndTime()->format('H:i:s');
    }

    public function getHour()
    {
        return $this->hour;
    }

    public function getMinute()
    {
        return $this->mintue;
    }

    public function getDepartmentId()
    {
        return $this->department_id;
    }

    public function getSiteId()
    {
        return $this->site_id;
    }

    public function getShiftId()
    {
        return $this->shift_id;
    }
}
