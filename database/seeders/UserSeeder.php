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

        DB::table('users')->insert([
            'id' => 1,
            'name' => "Babar Ali",
            'email' => 'admin@test.com',
            'password' => Hash::make('a'),
            'role' => 'Admin',
            'pic' => 'img/profile-default.svg',
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => "Processor Bina",
            'email' =>  'processor@test.com',
            'password' => Hash::make('a'),
            'role' => 'Processor',
            'created_by' => 1,
            'pic' => 'img/profile-default.svg',
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'name' => "Associate Bina",
            'email' =>  'associate@test.com',
            'password' => Hash::make('a'),
            'role' => 'Associate',
            'created_by' => 2,
            'pic' => 'img/profile-default.svg',
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => 4,
            'name' => "Junior Associate Bina",
            'email' =>  'juniorassociate@test.com',
            'password' => Hash::make('a'),
            'role' => 'Junior Associate',
            'created_by' => 3,
            'pic' => 'img/profile-default.svg',
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => 5,
            'name' => "Shaun Bina",
            'email' =>  'borrower@test.com',
            'password' => Hash::make('a'),
            'role' => 'Borrower',
            'finance_type' => 'Purchase',
            'loan_type' => 'Private Loan',
            'created_by' => 4,
            'pic' => 'img/profile-default.svg',
            'email_verified_at' => now(),
        ]);
    }
}
