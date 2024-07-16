<?php

namespace App\Http\Middleware;

use App\Helpers\SubscriptionHelper;
use App\Models\User;
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
        $user = Auth::user() ?? null;
        if ($user && $user->role !== 'Super Admin' && $user->role !== 'Admin' && $user->company && $user->company->subscription_id) {
            if (SubscriptionHelper::isExpired($user)) {
                return redirect('/logout');
            }
        }

        if ($user && $user->role === 'Admin' && $user->subscriptionDetails) {
            try {
                if (SubscriptionHelper::isExpired($user)) {
                    return redirect('premium-confirmation');
                }
            } catch (\Exception $e) {
                return redirect('premium-confirmation');
            }
        }
        return $next($request);
    }
}
