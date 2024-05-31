<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->role === 'Admin' && $user->subscriptionDetails) {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SK'));
            $sub_id = $user->subscriptionDetails->stripe_subscription_id;
            $stripedata = $stripe->subscriptions->retrieve($sub_id, []);
            $subscription = $stripedata->jsonSerialize();
            $period_end_at = date('Y-m-d H:i:s', $subscription['current_period_end']);
            if ($subscription['status'] != 'active' && $period_end_at < now()) {
                return redirect('premium-confirmation');
            }
        }
        return $next($request);
    }
}
