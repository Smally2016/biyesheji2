<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(TitleTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(SiteTableSeeder::class);
        $this->call(ShiftTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);
        $this->call(LeaveTypeTableSeeder::class);
        $this->call(RosterTableSeeder::class);
        $this->call(AttendanceTableSeeder::class);

        Model::reguard();
    }
}
