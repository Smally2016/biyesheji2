<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TitleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            '采购员',
            '贸易经理',
            '贸易主管',
            '贸易专员',
            '贸易助理',
            '业务跟单经理',
            '高级业务跟单',
            '业务跟单',
            '助理业务跟单',
            '报关员',
            '单证员',
            '船务人员',
        ];

        foreach ($titles as $title) {
            \App\Http\Models\TitleModel::create([
                'name' => $title,
                'full_name' => $title,
            ]);
        }
    }
}
