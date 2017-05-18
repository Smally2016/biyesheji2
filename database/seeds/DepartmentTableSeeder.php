<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            '进口部',
            '出口部',
            '单证部',
            '仓储部',
            '人事劳务科',
            '财务科',
        ];

        foreach ($departments as $department) {
            \App\Http\Models\DepartmentModel::create([
                'name' => $department,
                'status' => 1
            ]);
        }
    }
}
