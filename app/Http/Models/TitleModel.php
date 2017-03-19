<?php namespace App\Http\Models;

class TitleModel extends BaseModel
{

    protected $table = 'titles';
    protected $primaryKey = 'title_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'full_name', 'status', 'remark'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

}
