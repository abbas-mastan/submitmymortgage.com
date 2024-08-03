<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Team;
use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        Team::create([
            'name' => $faker->company,
            'company_id' => Company::first()->id,
            'owner_id' => User::first()->id,
        ]);
    }
}
