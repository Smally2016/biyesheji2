<?php namespace App\Http\Models;

class DepartmentSiteModel extends BaseModel
{

    protected $table = 'department_site';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['department_id', 'site_id'];

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
}
