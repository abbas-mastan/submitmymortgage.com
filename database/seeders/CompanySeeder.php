<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        Company::create([
            'name' => $faker->company,
        ]);
    }
}
