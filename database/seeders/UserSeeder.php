<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create an admin user
        DB::table('users')->insert([
            'name' => "Babar Ali",
            'email' => 'admin@test.com',
            'password' => Hash::make('a'),
            'role' => 'Super Admin',
            'pic' => 'img/profile-default.svg',
            'email_verified_at' => now(),
        ]);

        // Create a processor user
        for ($j = 1; $j <= 5; $j++) {

            DB::table('users')->insert([
                'name' => "Processor Bina $j",
                'email' => "processor$j@test.com",
                'password' => Hash::make('a'),
                'role' => 'Processor',
                'created_by' => 1, // Admin creates processor
                'pic' => 'img/profile-default.svg',
                'email_verified_at' => now(),
            ]);
        }

        // Create 5 associates created by the processor
        for ($i = 1; $i <= 5; $i++) {
            $associateId = DB::table('users')->insertGetId([
                'name' => "Associate Bina $i",
                'email' => "associate$i@test.com",
                'password' => Hash::make('a'),
                'role' => 'Associate',
                'created_by' => 2, // Processor creates associate
                'pic' => 'img/profile-default.svg',
                'email_verified_at' => now(),
            ]);

            // Create 5 junior associates for each associate
            for ($j = 1; $j <= 5; $j++) {
                $juniorAssociateId = DB::table('users')->insertGetId([
                    'name' => "Junior Associate Bina $j",
                    'email' => "juniorassociate$i$j@test.com", // Unique email address for each junior associate
                    'password' => Hash::make('a'),
                    'role' => 'Junior Associate',
                    'created_by' => $associateId, // Associate creates junior associate
                    'pic' => 'img/profile-default.svg',
                    'email_verified_at' => now(),
                ]);

                // Create 5 borrowers for each junior associate
                for ($k = 1; $k <= 5; $k++) {
                    DB::table('users')->insert([
                        'name' => "Borrower Bina $k",
                        'email' => "borrower$i$j$k@test.com", // Unique email address for each borrower
                        'password' => Hash::make('a'),
                        'role' => 'Borrower',
                        'finance_type' => 'Purchase',
                        'loan_type' => 'Private Loan',
                        'created_by' => $juniorAssociateId, // Junior associate creates borrower
                        'pic' => 'img/profile-default.svg',
                        'email_verified_at' => now(),
                    ]);
                }
            }
        }
    }
}
