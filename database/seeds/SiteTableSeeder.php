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

        $sites = [
            [
                'name' => '芝罘区',
                'status' => \App\Http\Models\SiteModel::STATUS_NORMAL,
                'lat' => '121.366412',
                'lng' => '37.528438',
                'address' => '烟台市芝罘区鲁东大学(北区)'
            ],
            [
                'name' => '驻京联络处',
                'status' => \App\Http\Models\SiteModel::STATUS_NORMAL,
                'lat' => '121.366412',
                'lng' => '37.528438',
                'address' => '北京市海淀区烟台市驻京联络处'
            ],
            [
                'name' => '鲁东国际',
                'status' => \App\Http\Models\SiteModel::STATUS_NORMAL,
                'lat' => '121.366412',
                'lng' => '37.528438',
                'address' => '烟台市福山区烟台经济技术开发区'
            ]
        ];

        foreach ($sites as $site) {
            $site = \App\Http\Models\SiteModel::create($site);
            $departments = \App\Http\Models\DepartmentModel::all();
            /** @var \App\Http\Models\DepartmentModel $department */
            foreach ($departments as $department) {
                $department->departmentSite()->create([
                    'site_id' => $site->site_id
                ]);
            }
        }

    }
}
