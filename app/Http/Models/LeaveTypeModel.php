<?php namespace App\Http\Models;

class LeaveTypeModel extends BaseModel
{

    protected $table = 'leave_types';
    protected $primaryKey = 'leave_type_id';

    protected $fillable = ['name', 'status','remark'];


    protected $hidden = [];

}
