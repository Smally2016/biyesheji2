<?php namespace App\Http\Models;

class DepartmentEmployeeModel extends BaseModel {

	protected $table = 'department_employee';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['department_id','employee_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

}
