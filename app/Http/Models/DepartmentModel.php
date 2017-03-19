<?php namespace App\Http\Models;

class DepartmentModel extends BaseModel
{

    protected $table = 'departments';
    protected $primaryKey = 'department_id';

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

    public function departmentEmployee()
    {
        return $this->hasMany('App\Http\Models\DepartmentEmployeeModel', 'department_id', 'department_id');
    }

    public function employee()
    {
        return $this->belongsToMany(
            'App\Http\Models\EmployeeModel',
            'department_employee',
            'department_id',
            'employee_id'
        );
    }

    public function users()
    {
        return $this->belongsToMany(
            UserModel::class,
            'department_user',
            'department_id',
            'user_id'
        );
    }

    public function site()
    {
        return $this->belongsToMany(
            'App\Http\Models\SiteModel',
            'department_site',
            'department_id',
            'site_id'
        );
    }

    public function departmentSite()
    {
        return $this->hasMany('App\Http\Models\DepartmentSiteModel', 'department_id', 'department_id');
    }

    public function departmentUser()
    {
        return $this->hasMany('App\Http\Models\DepartmentUserModel', 'department_id', 'department_id');
    }

    public function getCurrentEmployees()
    {
        return $this->employee()->where('status', EmployeeModel::CURRENT);

    }

}
