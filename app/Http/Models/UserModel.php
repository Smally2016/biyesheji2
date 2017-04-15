<?php namespace App\Http\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class UserModel extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'phone', 'password', 'name', 'remark', 'status', 'is_admin', 'created_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public static $create_rules = array(
        'username' => 'required|min:3|unique:users,username',
        'email' => 'min:4|unique:users,email',
        'password' => 'required|min:6'
    );

    const NORMAL = 0;
    const ADMIN = 1;
    const SUPER_ADMIN = 2;
    const EMPLOYEE = 3;

    const STATUS_BANED = 0;
    const STATUS_NORMAL = 1;

    public static $roles = [
        0 => 'Normal',
        1 => 'Admin',
        2 => 'Super Admin'
    ];

    public function departmentUser()
    {
        return $this->hasMany('App\Http\Models\DepartmentUserModel', 'user_id', 'user_id');
    }


    public function department()
    {
        return $this->belongsToMany(
            'App\Http\Models\DepartmentModel',
            'department_user',
            'user_id',
            'department_id'
        );
    }

    public function delete()
    {
        $this->departmentUser()->delete();
        return parent::delete();
    }

}
