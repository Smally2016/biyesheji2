<?php namespace App\Http\Models;

class DepartmentUserModel extends BaseModel
{

    protected $table = 'department_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['department_id', 'user_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function departments()
    {
        return $this->belongsToMany('App\Http\Models\DepartmentModel');
    }

}
