<?php

namespace App\Helpers;

use App\Models\User;
use Stripe\StripeClient;
use App\Models\CardDetails;
use App\Models\UserTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SubscriptionDetails;
use Illuminate\Support\Facades\Log;

class SubscriptionHelper
{
    public static function startTrialSubscription($customer_id, $user_id, $subscription_plan)
    {
        DB::beginTransaction();
        try {
            $date = date('Y-m-d H:i:s');
            $trial_days = strtotime($date . '+' . env('SUBSCRIPTION_TRIAL_DAYS') . ' days');
            $stripe = new StripeClient(env('STRIPE_SK'));
            $subscription = $stripe->subscriptions->create([
                'customer' => $customer_id,
                'items' => [
                    ['price' => $subscription_plan->stripe_price_id,
                        /*'price_1PHQb709tId2vnnu5137rCcH'*/
                    ],
                ],
                'trial_end' => $trial_days,
            ]);
            $plan = $stripe->plans->retrieve($subscription_plan->stripe_price_id, []);
            $subsription_details_data = SubscriptionDetails::insert([
                'user_id' => $user_id,
                'stripe_subscription_id' => $subscription->id,
                'stripe_subscription_schedule_id' => '',
                'stripe_customer_id' => $customer_id,
                'subscription_plan_price_id' => $plan->id,
                'plan_amount' => ($plan->amount / 100),
                'plan_amount_currency' => 'USD',
                'plan_interval' => $plan->interval,
                'plan_interval_count' => $plan->interval_count,
                'plan_starts_at' => $date,
                'plan_end_at' => date('Y-m-d H:i:s', strtotime('+1 month', strtotime($date))),
                'created' => date('Y-m-d H:i:s', $plan->created),
                'trial_end' => $trial_days,
                'status' => 'active',
                'created_at' => $date,
                'updated_at' => $date,
            ]);
            DB::commit();
            return $subsription_details_data;
        } catch (\Exception $e) {
            DB::rollback();
            Log::info($e->getMessage());
            return response()->json(['type' => 'stripe_error', 'message' => $e->getMessage()]);
        }
    }

    public static function charge($request)
    {
        try {
            $stripe = new StripeClient(env('STRIPE_SK'));
            // creates customer in stripe
            $customer = $stripe->customers->create([
                'description' => $request->email,
                'email' => $request->email,
                'source' => $request->stripeToken,
            ]);
            // charge only one dollar
            $charge = $stripe->charges->create([
                'amount' => (1 * 100),
                "currency" => "USD",
                'customer' => $customer->id,
                'description' => 'card-testing',
            ]);
            // charge only one dollar and instantly refunds it
            $stripe->refunds->create(['charge' => $charge->id]);
            return $customer;
        } catch (\Exception $e) {
            return response()->json(["type" => "stripe_error", "message" => $e->getMessage()]);
        }
    }

    public static function isExpired($user)
    {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SK'));
            $sub_id = $user->company->subscription_id;
            $stripedata = $stripe->subscriptions->retrieve($sub_id, []);
            $subscription = $stripedata->jsonSerialize();
            $period_end_at = date('Y-m-d H:i:s', $subscription['current_period_end']);
            if ($subscription['status'] != 'active' && $period_end_at < now()) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            return true;
        }
    }

    public static function insertPersonalInfo(Request $request, User $user)
    {
        $user->personalInfo()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
            ]);
    }

    public static function insertCardDetails($request, $customer_id, $user_id)
    {
        CardDetails::updateOrCreate(
            [
                'user_id' => $user_id,
                'card_no' => $request->card_no,
            ],
            [
                'user_id' => $user_id,
                'customer_id' => $customer_id,
                'card_id' => $request->card,
                'brand' => $request->brand,
                'month' => $request->month,
                'year' => $request->year,
                'card_no' => $request->card_no,
                'name' => $request->name ?? '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }

    public  static function insertSubscriptionInfo($user_id)
    {
        DB::table('user_subscription_infos')->insert([
            'user_id' => $user_id,
            'is_subscribed' => true,
            'trials_completed' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }


    public  static function userTraining($request, $user_id)
    {
        return UserTraining::updateOrCreate(
            ['user_id' => $user_id],
            [
                'user_id' => $user_id,
                'start_date' => $request->training,
                'start_time' => $request->time ?? null,
            ]
        );
    }
}
