<?php namespace App\Http\Models;

class SiteModel extends BaseModel
{
    const STATUS_NORMAL = 1;

    protected $table = 'sites';
    protected $primaryKey = 'site_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'status', 'remark', 'address', 'postal'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];


    public static $create_rules = array(
        'name' => 'required|unique:sites,name',
    );

    public function departmentSite()
    {
        return $this->hasMany('App\Http\Models\DepartmentSiteModel', 'site_id', 'site_id');
    }

    public function department()
    {
        return $this->belongsToMany(
            'App\Http\Models\DepartmentModel',
            'department_site',
            'site_id',
            'department_id'
        );
    }

    public function roster()
    {
        return $this->hasMany('App\Http\Models\RosterModel', 'site_id', 'site_id');
    }


    public function shift()
    {
        return $this->hasMany('App\Http\Models\ShiftModel', 'site_id', 'site_id');
    }
}
