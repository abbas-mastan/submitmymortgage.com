<?php

namespace App\Helpers;

use App\Models\SubscriptionDetails;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class SubscriptionHelper
{
    public static function startTrialSubscription($customer_id, $user_id, $subscription_plan)
    {
        try {
            $date = date('Y-m-d H:i:s');
            $trial_days = strtotime($date . '+' . 7 . ' days');
            $stripe = new StripeClient(env('STRIPE_SK'));
            $subscription = $stripe->subscriptions->create([
                'customer' => $customer_id,
                'items' => [['price' => $subscription_plan->stripe_price_id]],
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
            return $subsription_details_data;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['type' => 'stripe_error', 'message' => $e->getMessage()]);
        }
    }

    public static function charge($request)
    {
        try {
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
                'description' => 'card-testing',
            ]);
            $stripe->refunds->create(['charge' => $charge->id]);
            return $customer;
        } catch (\Exception $e) {
            return response()->json(["type" => "stripe_error", "message" => $e->getMessage()]);
        }
    }

}
