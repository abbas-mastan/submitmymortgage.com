<?php

namespace App\Helpers;

use App\Models\SubscriptionDetails;
use App\Models\UserSubscriptionInfo;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class SubscriptionHelper
{
    public static function startTrialSubscription($customer_id, $user_id, $subscription_plan)
    {
        try {
            UserSubscriptionInfo::insert(['user_id'=> $user_id,'is_subscribed'=> true]);
            $current_period_start = date('Y-m-d H:i:s');
            $date = date('Y-m-d 23:59:59');
            $trial_days = strtotime($date . '+' . $subscription_plan->trial_days . 'days');
            $stripe = new StripeClient(env('STRIPE_SK'));
            $subscription = $stripe->subscriptions->create([
                'customer' => $customer_id,
                'items' => [['price' => $subscription_plan->stripe_price_id]],
                'trial_end' => strtotime("$subscription_plan->trial_days days"),
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
                'plan_starts_at' => $current_period_start,
                'plan_end_at' => date('Y-m-d H:i:s', strtotime('+1 month', strtotime($current_period_start))),
                'created' => date('Y-m-d H:i:s', $plan->created),
                'trial_end' => $trial_days,
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return $subsription_details_data;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return null;
        }
    }

    public static function charge($request)
    {
        $stripe = new StripeClient(env('STRIPE_SK'));
        $customer = $stripe->customers->create([
            'description' => $request->email,
            'email' => $request->email,
            'source' => $request->stripeToken,
        ]);
        $charge = $stripe->charges->create([
            'amount' => (1 * 100),
            "currency" => "USD",
            'customer' => $customer->id,
            'description' => ' test desciption',
        ]);
        $stripe->refunds->create(['charge' => $charge->id]);
        return $customer;
    }

}
