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
            'firstname' => 'Admin',
            'email' => 'admin@wyzinventory.com',
            'phone' => '08062239566',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Auditor',
            'email' => 'auditor@wyzinventory.com',
            'phone' => '08022239566',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Shop Keepper',
            'email' => 'shopkeeper@wyzinventory.com',
            'phone' => '080622395209',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Shop Keepper',
            'email' => 'shopkeeper2@wyzinventory.com',
            'phone' => '08062256266',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Shop Keepper',
            'email' => 'shopkeeper3@wyzinventory.com',
            'phone' => '08062233216',
            'password' => bcrypt('123456'),
        ]);
    }
}
