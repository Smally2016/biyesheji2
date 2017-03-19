<?php namespace App\Http\Models;

class ReaderModel extends BaseModel
{

    protected $table = 'readers';
    protected $primaryKey = 'reader_id';

    protected $fillable = ['reader_id', 'site_id', 'name', 'remark'];


    protected $hidden = [];

    public static $create_rules = array(
        'reader_id' => 'required|numeric|unique:readers,reader_id',
    );

    public function site()
    {
        return $this->belongsTo('App\Http\Models\SiteModel', 'site_id', 'site_id');
    }

}
