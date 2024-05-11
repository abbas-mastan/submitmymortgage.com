<?php

namespace App\Http\Controllers;

use App\Helpers\SubscriptionHelper;
use App\Mail\AdminMail;
use App\Mail\CustomQuoteMail;
use App\Models\CardDetails;
use App\Models\Company;
use App\Models\CustomQuote;
use App\Models\SubscriptionPlans;
use App\Models\User;
use App\Models\UserTraining;
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

    public function finishTrial()
    {
        $user = Auth::user();
        $stripe = new StripeClient(env('STRIPE_SK'));
        $sub_id = $user->subscriptionDetails->stripe_subscription_id;
        $cus_id = $user->subscriptionDetails->stripe_customer_id;
        $price_id = $user->subscriptionDetails->subscription_plan_price_id;
        $subscription_old = $stripe->subscriptions->retrieve($sub_id, []);
        $subscription = $stripe->subscriptions->resume(
            $sub_id,
            ['billing_cycle_anchor' => 'now']
        );

        dd($subscription->jsonSerialize());
    }

    public function processPayment(Request $request)
    {
        $validator = $this->ValidateUser($request);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            try {
                $customer = SubscriptionHelper::charge($request);
                if ($customer instanceof \Stripe\Customer) {
                    $subscriptionPlan = SubscriptionPlans::where('name', $request->team_size)->first();
                    // create company with users starts
                    $user = $this->createUserWithCompany($request, $subscriptionPlan->max_users);
                    // create company with users end
                    $customer_id = $customer->id;
                    $user_id = $user->id;
                    $this->userTraining($request, $user_id);
                    $id = Crypt::encryptString($user_id);
                    DB::table('password_resets')->insert(['email' => $user->email, 'token' => Hash::make(Str::random(12)), 'created_at' => now()]);
                    $url = function () use ($id) {return URL::signedRoute('user.register', ['user' => $id], now()->addMinutes(10));};
                    Mail::to($request->email)->send(new AdminMail($url()));
                    $this->insertCardDetails($request, $customer_id, $user_id);
                    $this->insertSubscriptionInfo($user_id);
                    if ($subscriptionPlan) {
                        $subscriptionData = SubscriptionHelper::startTrialSubscription($customer_id, $user_id, $subscriptionPlan);
                    }
                    if ($user->email_verified_at == null && $subscriptionData) {
                        $this->loginwithid($user->id);
                        return response()->json('redirect');
                    }
                } else {
                    return $customer;
                }
            } catch (\Exception $e) {
                return response()->json(['type' => 'stripe_error', 'message' => $e->getMessage() . 'asdfasdf']);
            }
        }
    }

    public function userTraining($request, $user_id)
    {
        return UserTraining::updateOrCreate(
            ['user_id' => $user_id],
            [
                'user_id' => $user_id,
                'start_date' => $request->training,
                'start_time' => $request->time ?? null,
            ]
        );
    }
    protected function createUserWithCompany($request, $max_users)
    {
        $company = Company::create(['name' => $request->company, 'max_users' => $max_users]);
        $user = new User();
        $user->email = $request->email;
        $user->phone = $request->phone ?? null;
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->role = 'Admin';
        $user->company_id = $company->id;
        $user->password = 'null';
        $user->pic = 'img/profile-default.svg';
        $user->save();
        return $user;
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

    protected function insertSubscriptionInfo($user_id)
    {
        DB::table('user_subscription_infos')->insert([
            'user_id' => $user_id,
            'is_subscribed' => true,
            'trials_completed' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function CustomQuote(Request $request)
    {
        // return response()->json($request->all());
        $validator = $this->ValidateUser($request);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user = $this->createUserWithCompany($request, 0);
        Mail::to($user->email)->send(new CustomQuoteMail());
        CustomQuote::create(['plan_type' => $request->team_size === 'yearly-plan-6' ? 'year' : 'monthly', 'user_id' => $user->id]);
        return response()->json('redirect');
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
            'email' => 'required|email:rfc|unique:users,email',
            'phone' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'company' => 'required',
            'team_size' => 'required',
            'training' => $customValidation,
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
            $user = Auth::user()->subscriptionDetails;
            $stripe = new StripeClient(env('STRIPE_SK'));
            $stripe->subscriptions->create([
                'customer' => $user->stripe_customer_id,
                'items' => [['price' => $user->subscription_plan_price_id]],
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
                $stripe->charges->create([
                    'amount' => 100 * 1000,
                    "currency" => "USD",
                    'customer' => $customer->id ?? $user->trial->customer_id,
                    'description' => ' test desciption',
                ]);
            } catch (\Exception $e) {

            }
        }

    }

    public function cancelSubscription()
    {
        $user = Auth::user();
        $sub_id = $user->subscriptionDetails->stripe_subscription_id;
        $stripe = new \Stripe\StripeClient('sk_test_51P6SBB09tId2vnnum7ibbbCIHgacCrrJc1G78LXEYK81LKH0lfMgmVcAzFQySdadJok5xnOwRvEVNqw9m1aiV0qi00Kihjo2GB');
        $stripe->subscriptions->cancel($sub_id, []);
        $user->userSubscriptionInfo->update(['is_subscribed' => false]);
        return back()->with(['msg_success', 'Subscription cancled!']);
    }
}
