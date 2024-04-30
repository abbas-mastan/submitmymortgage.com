<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\AdminMail;
use Stripe\StripeClient;
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

class SubscriptionController extends Controller
{
    public function processPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'team_size' => 'required',
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
                $customer = $this->charge($request,$name);                
                if($customer){
                    // DB::table('card_details')->insert([
                    //     'user_id' => auth()->user()->id,
                    //     'customer_id' => $customer->id ,
                    //     'card_id' => $customer->default_source,
                    // ]);
                    DB::table('users')->insert([
                        'email' => $request->email,
                        'name' => $name,
                        'role' => 'Admin',
                        'password' => 'null',
                        'pic' => 'img/profile-default.svg',
                        'created_at' => now(),
                    ]);
                }

                $msg['msg_info'] = 'Please check your email inbox to verify email.';
                $user = User::where('email', $request->email)->first();

                $id = Crypt::encryptString($user->id);
                DB::table('password_resets')->insert(['email' => $user->email, 'token' => Hash::make(Str::random(12)), 'created_at' => now()]);
                $url = function () use ($id) {return URL::signedRoute('user.register', ['user' => $id], now()->addMinutes(10));};
                Mail::to($request->email)->send(new AdminMail($url()));
                DB::table('trials')->insert([
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'postal_code' => $request->postal_code,
                    'customer_id' => $customer->id, //$customer->id,
                    'user_id' => $user->id, //$customer->id,
                    'trial_started_at' => now(),
                ]);
                if ($user->email_verified_at == null) {
                    $this->loginwithid($user->id);
                    return redirect()->route('verification.notice');
                }
                return response()->json('user-created');
            } catch (\Exception $e) {
                Session::put('user_data', $request->all());
                return back()->with('stripe_error', $e->getMessage());
            }
        } else {
            return response()->json('success');
        }
    }


    public function charge($request,$name)
    {
        $stripe = new StripeClient(env('STRIPE_SK'));
        $customer = $stripe->customers->create([
            'description' => $name,
            'email' => $request->email,
            'source' => $request->stripeToken,
        ]);
        $charge = $stripe->charges->create([
            'amount' => 100 * 1,
            "currency" => "USD",
            'customer' => $customer->id,
            'description' => ' test desciption',
        ]);
        $stripe->refunds->create(['charge' => $charge->id]);
        return $customer;
    }

    public function loginwithid($id)
    {
        return Auth::loginUsingId($id);
    }

    public function trialCompleted($msg)
    {
        return view('payment-page')->with('msg_error', $msg);
    }

    public function continuePremium(Request $request)
    {
        try {
            $user = Auth::user();
            $stripe = new StripeClient(env('STRIPE_SK'));
            $stripe->charges->create([
                'amount' => 100 * 1000,
                "currency" => "USD",
                'customer' => $user->trial->customer_id,
                'description' => ' test desciption',
            ]);
            return redirect('/dashboard')->with('msg_success', 'Subscription completed successfully.');
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return view('payment-page')->with('msg_error', $msg);
        }
    }

    public function processPaymentWithStripe(Request $request)
    {

        $user = Auth::user();
        $stripe = new StripeClient(env('STRIPE_SK'));
        if ($request->stripeToken) {
            try {

                $customer = $stripe->customers->create([
                    'description' => $user->name,
                    'email' => $user->email,
                    'source' => $request->stripeToken,
                ]);
            } catch (\Exception $e) {

            }

        }
        $stripe->charges->create([
            'amount' => 100 * 1000,
            "currency" => "USD",
            'customer' => $customer->id ?? $user->trial->customer_id,
            'description' => ' test desciption',
        ]);
    }

    public function stripeSuccess($msg = null)
    {
        $user = Auth::user();
        $user->trial->update([
            'trial_started_at' => $user->trial->trial_started_at,
            'subscribed_at' => now(),
        ]);
        return view('dashboard')->with('msg_success', $msg);
    }
    public function stripeFailed()
    {
        dd('payment failed');
    }
}
