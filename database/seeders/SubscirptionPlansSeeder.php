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
            ['name' => 'monthly-plan-1', 'stripe_price_id' => 'price_1PAtvR09tId2vnnuSnUAMZ0L', 'trial_days' => '7', 'amount' => 500, 'created_at' => $time],
            ['name' => 'monthly-plan-2', 'stripe_price_id' => 'price_1PAtxQ09tId2vnnuVAW315c6', 'trial_days' => '7', 'amount' => 1000, 'created_at' => $time],
            ['name' => 'monthly-plan-3', 'stripe_price_id' => 'price_1PAty509tId2vnnuSWqxhvfO', 'trial_days' => '7', 'amount' => 1500, 'created_at' => $time],
            ['name' => 'monthly-plan-4', 'stripe_price_id' => 'price_1PAtym09tId2vnnurTFST738', 'trial_days' => '7', 'amount' => 2000, 'created_at' => $time],
            ['name' => 'monthly-plan-5', 'stripe_price_id' => 'price_1PAu0V09tId2vnnuAZxytrUj', 'trial_days' => '7', 'amount' => 2500, 'created_at' => $time],
            ['name' => 'yearly-plan-1', 'stripe_price_id' => 'price_1PAu1709tId2vnnu8s7rkeHS', 'trial_days' => '7', 'amount' => 4500, 'created_at' => $time],
            ['name' => 'yearly-plan-2', 'stripe_price_id' => 'price_1PAu1e09tId2vnnuxeLv9yjR', 'trial_days' => '7', 'amount' => 9000, 'created_at' => $time],
            ['name' => 'yearly-plan-3', 'stripe_price_id' => 'price_1PAu2709tId2vnnua2b2Qxti', 'trial_days' => '7', 'amount' => 13500, 'created_at' => $time],
            ['name' => 'yearly-plan-4', 'stripe_price_id' => 'price_1PAu2h09tId2vnnunLNPfyTv', 'trial_days' => '7', 'amount' => 18000, 'created_at' => $time],
            ['name' => 'yearly-plan-5', 'stripe_price_id' => 'price_1PAu3Y09tId2vnnuXDeYWOX2', 'trial_days' => '7', 'amount' => 22500, 'created_at' => $time],
        ];
        DB::table('subscription_plans')->insert($data);
    }
}
