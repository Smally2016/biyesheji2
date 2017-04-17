<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department_sites = \App\Http\Models\DepartmentSiteModel::all();

        /** @var \App\Http\Models\DepartmentSiteModel $department_site */
        foreach ($department_sites as $department_site) {
            \App\Http\Models\ShiftModel::create([
                'department_id' => $department_site->department_id,
                'site_id' => $department_site->site_id,
                'start_time' => '09:00:00',
                'hour' => '9',
                'minute' => '0',
                'status' => 1,
            ]);
        }
    }
}
