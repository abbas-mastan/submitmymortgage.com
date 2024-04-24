<?php

namespace App\Http\Controllers;

use App\Mail\AssistantMail;
use App\Models\Trial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Stripe\StripeClient;

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
                $stripe = new StripeClient(env('STRIPE_SK'));
                $customer = $stripe->customers->create([
                    'description' => $name,
                    'email' => $request->email,
                    'source' => $request->stripeToken,
                ]);
                $stripe->charges->create([
                    'amount' => 100 * 1,
                    "currency" => "USD",
                    'customer' => $customer->id,
                    'description' => ' test desciption',
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
            // if ($e->getStripeCode() === 'card_declined') {
            // $stripe = new \Stripe\StripeClient('sk_test_51P6SBB09tId2vnnum7ibbbCIHgacCrrJc1G78LXEYK81LKH0lfMgmVcAzFQySdadJok5xnOwRvEVNqw9m1aiV0qi00Kihjo2GB');
            // $session = $stripe->checkout->sessions->create([
            //     'line_items' => [[
            //         'price_data' => [
            //             'currency' => 'usd',
            //             'product_data' => [
            //                 'name' => 'Monthly Subscription',
            //             ],
            //             'unit_amount' => 100 * 200,
            //         ],
            //         'quantity' => 1,
            //     ]],
            //     'mode' => 'payment',
            //     'success_url' => route('success'),
            //     'cancel_url' => route('failed'),
            // ]);
            // return redirect($session->url);
        }
        // }
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
