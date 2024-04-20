<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trial;
use App\Mail\AssistantMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StripeController extends Controller
{

    public function trial()
    {
        // dd(DB::table('trials')->get());
        // dd(User::all());
        return view('trial');
    }

    public function trialDashboard()
    {
        return 'trials-dashboard';
        return view('trial-dashboard');
    }
    public function processPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            // 'stripeToken' => 'required_with_all:email,phone,first_name,last_name,address,country,state,city,postal_code',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } elseif (!$validator->fails() && $request->stripeToken) {
            $name = $request->first_name . ' ' . $request->last_name;
            try {
                
                $stripe = new \Stripe\StripeClient(env('STRIPE_SK'));
                $customer = $stripe->customers->create([
                'description' => $name,
                'email' => $request->email,
                'source' => $request->stripeToken,
            ]);
            DB::table('users')->insert([
                'email' => $request->email,
                'name' => $name,
                'role' => 'Borrower',
                'password' => 'null',
                'pic' => 'img/profile-default.svg',
                'finance_type' => 'purchase',
                'loan_type' => 'Private Loan',
                'created_at' => now(),
            ]);
            
            $msg['msg_info'] = 'Please check your email inbox to verify email.';
            $user = User::where('email', $request->email)->first();
            
            $id = Crypt::encryptString($user->id);
            DB::table('password_resets')->insert(['email' => $user->email, 'token' => Hash::make(Str::random(12)), 'created_at' => now()]);
            $url = function () use ($id) {return Url::signedRoute('user.register', ['user' => $id], now()->addMinutes(10));};
            Mail::to($request->email)->send(new AssistantMail($url()));
            
            DB::table('trials')->insert([
                'address' => $request->address,
                'phone' => $request->phone,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'customer_id' => $customer->id, //$customer->id,
                'user_id' => $user->id, //$customer->id,
                'trial_started_at' => '2024-04-09 14:53:50',
            ]);
            if ($user->email_verified_at == null) {
                $this->loginwithid($user->id);
                return redirect()->route('verification.notice');
            }
            return response()->json('user-created');
        } catch (\Exception $e) {
            Session::put('user_data',$request->all());
            return back()->with('stripe_error',$e->getMessage());
        }
        } else {
            return response()->json('success');
        }
    }
    
    public function loginwithid($id)
    {
        return Auth::loginUsingId($id);
    }

    public function trialCompleted()
    {
        return view('premium-confirmation')->with('msg_trial', 'Your trial period has been completed.<br> Would you like to continue with premium?');
    }

    public function continuePremium()
    {
        $user = Auth::user();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SK'));
        try {
         $charge = $stripe->charges->create([
                'amount' => 120000,
                "currency" => "USD",
                'customer' => $user->trial->customer_id,
                'description' => ' test desciption',
            ]);

        } catch (\Exception $e) {
            // dd($e);
            dd($e->getStripeCode());
        }

        dd($charge);
        $user->trial->update([
            'subscribed_at' => now(),
            'trial_started_at' => $user->trial->trial_started_at,
        ]);
        return redirect('/dashboard')->with('msg_success', 'Subscription completed successfully.');
    }

}
