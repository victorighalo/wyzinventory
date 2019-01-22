<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => 'Administrator',
            'email' => 'admin@wyzinventory.com',
            'phone' => '08062239670',
            'active' => 1,
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Auditor',
            'email' => 'auditor@wyzinventory.com',
            'phone' => '08062239671',
            'active' => 1,
            'password' => bcrypt('123456'),
        ]);
    }
}
