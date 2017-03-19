<?php namespace App\Http\Models;

class SSTitleModel extends BaseModel
{
    protected $connection = 'ss';
    protected $table = 'employee_role';
    protected $primaryKey = 'employee_role_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'status', 'remark'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

}
