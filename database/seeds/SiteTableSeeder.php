<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $site = \App\Http\Models\SiteModel::create([
            'name' => '鲁东大学北区',
            'status' => \App\Http\Models\SiteModel::STATUS_NORMAL,
            'lat' => '121.366412',
            'lng' => '37.528438',
            'remark' => '鲁东大学北区'
        ]);

        $departments = \App\Http\Models\DepartmentModel::all();
        /** @var \App\Http\Models\DepartmentModel $department */
        foreach ($departments as $department) {
            $department->departmentSite()->create([
                'site_id' => $site->site_id
            ]);
        }
    }
}
