<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'username' => 'root',
            'name' => 'root',
            'email' => '',
            'password' => bcrypt('abc123456'),
            'status' => 1,
            'is_admin' => 1,
        ]);
    }
}
