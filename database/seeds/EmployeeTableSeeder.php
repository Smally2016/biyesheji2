<?php

use App\Http\Models\UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            [
                'title_id' => 1,
                'id' => '100000',
                'name' => '安楷瑞',
                'nric' => '510822198802145091',
                'dob' => \Carbon\Carbon::now()->subYear(rand(20, 50))->subDay(rand(1, 365))->format('Y-m-d'),
                'gender' => '男',
                'nationality' => '中国',
                'religion' => '无',
                'email' => '100000@email.com',
                'address' => '四川省',
                'address_postal' => '000001',
                'phone' => '17100000001',
                'status' => 1,
                'date_joined' => \Carbon\Carbon::now()->subDay(rand(1, 1365))->format('Y-m-d'),
            ],
            [
                'title_id' => 2,
                'id' => '100001',
                'name' => '平明远',
                'nric' => '152530198806274534',
                'dob' => \Carbon\Carbon::now()->subYear(rand(20, 50))->subDay(rand(1, 365))->format('Y-m-d'),
                'gender' => '男',
                'nationality' => '中国',
                'religion' => '无',
                'email' => '100002@email.com',
                'address' => '内蒙古自治区',
                'address_postal' => '000011',
                'phone' => '17100000002',
                'status' => 1,
                'date_joined' => \Carbon\Carbon::now()->subDay(rand(1, 1365))->format('Y-m-d'),
            ],
            [
                'title_id' => 3,
                'id' => '100003',
                'name' => '鲁博超',
                'nric' => '441500198003166556',
                'dob' => \Carbon\Carbon::now()->subYear(rand(20, 50))->subDay(rand(1, 365))->format('Y-m-d'),
                'gender' => '男',
                'nationality' => '中国',
                'religion' => '无',
                'email' => '100003@email.com',
                'address' => '广东省',
                'address_postal' => '000013',
                'phone' => '17100000003',
                'status' => 1,
                'date_joined' => \Carbon\Carbon::now()->subDay(rand(1, 1365))->format('Y-m-d'),
            ],
            [
                'title_id' => 4,
                'id' => '100004',
                'name' => '邹飞烟',
                'nric' => '131082197103178386',
                'dob' => \Carbon\Carbon::now()->subYear(rand(20, 50))->subDay(rand(1, 365))->format('Y-m-d'),
                'gender' => '女',
                'nationality' => '中国',
                'religion' => '无',
                'email' => '100004@email.com',
                'address' => '河北省',
                'address_postal' => '000014',
                'phone' => '17100000004',
                'status' => 1,
                'date_joined' => \Carbon\Carbon::now()->subDay(rand(1, 1365))->format('Y-m-d'),
            ],
            [
                'title_id' => 5,
                'id' => '100005',
                'name' => '方红雪',
                'nric' => '150304197103207968',
                'dob' => \Carbon\Carbon::now()->subYear(rand(20, 50))->subDay(rand(1, 365))->format('Y-m-d'),
                'gender' => '女',
                'nationality' => '中国',
                'religion' => '无',
                'email' => '100005@email.com',
                'address' => '内蒙古自治区',
                'address_postal' => '000015',
                'phone' => '17100000005',
                'status' => 1,
                'date_joined' => \Carbon\Carbon::now()->subDay(rand(1, 1365))->format('Y-m-d'),
            ],
            [
                'title_id' => 6,
                'id' => '100006',
                'name' => '周古韵',
                'nric' => '210804197202151449',
                'dob' => \Carbon\Carbon::now()->subYear(rand(20, 50))->subDay(rand(1, 365))->format('Y-m-d'),
                'gender' => '女',
                'nationality' => '中国',
                'religion' => '无',
                'email' => '100006@email.com',
                'address' => '辽宁省',
                'address_postal' => '000016',
                'phone' => '17100000006',
                'status' => 1,
                'date_joined' => \Carbon\Carbon::now()->subDay(rand(1, 1365))->format('Y-m-d'),
            ],
        ];

        foreach ($employees as $key => $employee) {
            $new_employee = \App\Http\Models\EmployeeModel::create($employee);
            /** @var \App\Http\Models\DepartmentModel $department */
            $department = \App\Http\Models\DepartmentModel::find($key + 1);
            $department->departmentEmployee()->create([
                'employee_id' => $new_employee->employee_id
            ]);

            $user = UserModel::create([
                'phone' => $employee['phone'],
                'username' => $employee['phone'],
                'password' => bcrypt($employee['phone']),
                'email' => $employee['email'],
                'is_admin' => UserModel::EMPLOYEE,
                'status' => UserModel::STATUS_NORMAL
            ]);

            $new_employee->update([
                'user_id' => $user->user_id
            ]);
        }
    }
}
