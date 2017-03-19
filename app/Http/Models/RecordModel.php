<?php namespace App\Http\Models;

use Carbon\Carbon;

class RecordModel extends BaseModel
{

    protected $table = 'records';
    protected $primaryKey = 'record_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date_time', 'nric', 'name', 'mode', 'id', 'reader_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function displayDate()
    {
        return Carbon::parse($this->date_time)->format('d/m/Y');
    }

    public function displayTime()
    {
        return Carbon::parse($this->date_time)->format('H:i:s');
    }


}
