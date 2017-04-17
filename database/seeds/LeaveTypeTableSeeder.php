<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LeaveTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            '年假',
            '病假',
            '公共假期',
        ];

        foreach ($types as $type) {
            \App\Http\Models\LeaveTypeModel::create([
                'name' => $type,
                'status' => \App\Http\Models\LeaveModel::STATUS_NORMAL,
            ]);
        }
    }
}
