<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class PasswordExpiredMiddleware
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
        
        $user = $request->user();
        $password_chaged_at = new Carbon(($user->password_changed_at) ? $user->password_changed_at : $user->email_verified_at);
        if ($user->role !== 'Super Admin' && !session()->has('reLogin') && Carbon::now()->diffInDays($password_chaged_at) >= config('auth.password_expires_days')) {
            return redirect()->route('password.expired');
        }
        return $next($request);
    }
}
