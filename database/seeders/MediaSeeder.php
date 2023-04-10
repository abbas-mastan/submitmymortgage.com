<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        DB::table('users')->insert([
            'id' => 1,
            'file_name' => "credit form",
            'file_path' =>  'img/profile-default.svg',
            'file_size' => 2025,
            'file_type' => "svg",
            'file_extension' => "svg",
            'user_id' => 1,
        ]);
    }
}
