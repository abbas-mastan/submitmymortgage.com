<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscirptionPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = now();
        $data = [
            ['name' => 'monthly-plan-1', 'stripe_price_id' => 'price_1PDhk109tId2vnnueRGJ22ef', 'trial_days' => '7', 'amount' => 500,  'max_users'=> 2,'created_at' => $time],
            ['name' => 'monthly-plan-2', 'stripe_price_id' => 'price_1PDhkz09tId2vnnuTMT0PkXL', 'trial_days' => '7', 'amount' => 1000, 'max_users'=> 5, 'created_at' => $time],
            ['name' => 'monthly-plan-3', 'stripe_price_id' => 'price_1PDhlV09tId2vnnugGHlqPQH', 'trial_days' => '7', 'amount' => 1500, 'max_users'=> 10, 'created_at' => $time],
            ['name' => 'monthly-plan-4', 'stripe_price_id' => 'price_1PDhm909tId2vnnuSokOGzpN', 'trial_days' => '7', 'amount' => 2000, 'max_users'=> 15, 'created_at' => $time],
            ['name' => 'monthly-plan-5', 'stripe_price_id' => 'price_1PDhmj09tId2vnnulFoxYVCw', 'trial_days' => '7', 'amount' => 2500, 'max_users'=> 20, 'created_at' => $time],
            ['name' => 'yearly-plan-1', 'stripe_price_id' => 'price_1PDhnR09tId2vnnu0OhU1Rt1', 'trial_days' => '7', 'amount' => 4500, 'max_users'=> 2, 'created_at' => $time],
            ['name' => 'yearly-plan-2', 'stripe_price_id' => 'price_1PDho809tId2vnnulmqRQpaC', 'trial_days' => '7', 'amount' => 9000, 'max_users'=> 5, 'created_at' => $time],
            ['name' => 'yearly-plan-3', 'stripe_price_id' => 'price_1PDhog09tId2vnnu1V9Rocqj', 'trial_days' => '7', 'amount' => 13500, 'max_users'=> 10, 'created_at' => $time],
            ['name' => 'yearly-plan-4', 'stripe_price_id' => 'price_1PDhpF09tId2vnnuXjxasOPS', 'trial_days' => '7', 'amount' => 18000, 'max_users'=> 15, 'created_at' => $time],
            ['name' => 'yearly-plan-5', 'stripe_price_id' => 'price_1PDhqX09tId2vnnuOLClYPcE', 'trial_days' => '7', 'amount' => 22500, 'max_users'=> 20, 'created_at' => $time],
        ];
        DB::table('subscription_plans')->insert($data);
    }
}
