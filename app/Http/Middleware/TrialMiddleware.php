<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TrialMiddleware
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
        $subscribedAt = $user->trial->subscribed_at;
        $month = now()->subDays(30);
        if (Auth::check() && $user->role === 'Borrower' && $user->trial && !$subscribedAt) {
            $trialStartDate = $user->trial->trial_started_at;
            $sevenDaysAgo = now()->subDays(7);
            if ($trialStartDate < $sevenDaysAgo && !$subscribedAt) {
                return redirect('/continue-to-premium');
            }
        }
        if ($subscribedAt && $subscribedAt < $month) {
            return redirect('/continue-to-premium');
            // $msg_trial = 'Your monthly subscription completed. <br>Would you like to continue?';
            // Session::put('msg_trial',$msg_trial);
            // return redirect('premium-confirmation')->with('msg_trial',$msg_trial);
        }

        return $next($request);
    }
}
