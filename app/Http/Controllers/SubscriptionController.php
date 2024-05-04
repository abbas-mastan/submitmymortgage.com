<?php

namespace App\Http\Controllers;

use App\Helpers\SubscriptionHelper;
use App\Mail\AdminMail;
use App\Models\CardDetails;
use App\Models\SubscriptionPlans;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class SubscriptionController extends Controller
{

    public function processPayment(Request $request)
    {
        $validator = $this->ValidateUser($request);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $name = $request->first_name . ' ' . $request->last_name;
            try {
                $customer = SubscriptionHelper::charge($request);
                if ($customer) {
                    DB::table('users')->insert([
                        'email' => $request->email,
                        'name' => $name,
                        'role' => 'Admin',
                        'password' => 'null',
                        'pic' => 'img/profile-default.svg',
                        'created_at' => now(),
                    ]);
                } else {
                    return response()->json('something went wrong');
                }
                $msg['msg_info'] = 'Please check your email inbox to verify email.';
                $user = User::where('email', $request->email)->first();
                $customer_id = $customer->id;
                $user_id = $user->id;
                $id = Crypt::encryptString($user_id);
                DB::table('password_resets')->insert(['email' => $user->email, 'token' => Hash::make(Str::random(12)), 'created_at' => now()]);
                $url = function () use ($id) {return URL::signedRoute('user.register', ['user' => $id], now()->addMinutes(10));};
                Mail::to($request->email)->send(new AdminMail($url()));
                $this->insertCardDetails($request, $customer_id, $user_id);
                $this->createTrial($request, $customer_id, $user_id);
                $subscriptionPlan = SubscriptionPlans::where('name', $request->team_size)->first();
                if ($subscriptionPlan) {
                    $subscriptionData = SubscriptionHelper::startTrialSubscription($customer_id, $user_id, $subscriptionPlan);
                }
                if ($user->email_verified_at == null && $subscriptionData) {
                    $this->loginwithid($user->id);
                    return response()->json('redirect');
                }
                return response()->json('something went wrong');
            } catch (\Exception $e) {
                return response()->json('something went wrong');
                // Session::put('user_data', $request->all());
                // return response()->json($e->getMessage());
                // return back()->with('stripe_error', $e->getMessage());
            }
        }
    }

    protected function insertCardDetails($request, $customer_id, $user_id)
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
    protected function createTrial($request, $customer_id, $user_id)
    {
        DB::table('trials')->insert([
            'address' => $request->address,
            'phone' => $request->phone,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'customer_id' => $customer_id, //$customer->id,
            'user_id' => $user_id, //$customer->id,
            'trial_started_at' => now(),
        ]);
    }

    public function CustomQuote(Request $request)
    {
        $validator = $this->ValidateUser($request);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
    }

    protected function ValidateUser($request)
    {
        $customValidation = function ($attribute, $value, $fail) use ($request) {
            if ($this->customValidation($request->team_size)) {
                if (empty($value)) {
                    $fail('The ' . $attribute . ' field is required.');
                }
            }
        };
        return Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'team_size' => 'required',
            'address' => $customValidation,
            'country' => $customValidation,
            'state' => $customValidation,
            'city' => $customValidation,
            'postal_code' => $customValidation,
            // 'stripeToken' => 'required_with_all:email,phone,first_name,last_name,address,country,state,city,postal_code',
        ]);
    }

    protected function customValidation($value)
    {
        if ($value === 'monthly-plan-6' || $value === 'yearly-plan-6') {
            return false; // Address should not be required
        }
        return true; // Address should be required
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
