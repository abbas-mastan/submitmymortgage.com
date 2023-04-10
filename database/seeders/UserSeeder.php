<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'id' => 1,
            'name' => "Shaun Bina",
            'email' =>  'u@u.com',
            'password' => Hash::make('a'),
            'role' => 'user',
            'finance_type' => 'Purchase',
            'pic' => 'img/profile-default.svg',
            'email_verified_at' => now(),
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'name' => "Babar Ali",
            'email' => 'a@a.com',
            'password' => Hash::make('a'),
            'role' => 'admin',
            'pic' => 'img/profile-default.svg',
            'email_verified_at' => now(),
        ]);
        
    }
}
