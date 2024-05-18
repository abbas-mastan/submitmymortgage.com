<?php

namespace App\Http\Controllers;

use App\Helpers\SubscriptionHelper;
use App\Mail\AdminMail;
use App\Mail\CancelSubscriptionMail;
use App\Mail\CustomQuoteMail;
use App\Models\CardDetails;
use App\Models\Company;
use App\Models\CustomQuote;
use App\Models\PaymentDetail;
use App\Models\SubscriptionDetails;
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
        $customer = $stripe->customers->retrieve($cus_id, []);

        $session = $stripe->customerSessions->create([
            'customer' => $cus_id,
            'components' => ['pricing_table' => ['enabled' => true]],
        ]);
        dump(date('Y-m-d H:i:s',$session->expires_at));
        dump("2024-05-18 07:06:28");
        dump($session);
        dd($customer);
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
            'training' => [$customValidation, 'date'],
            'address' => $customValidation,
            'country' => $customValidation,
            'state' => $customValidation,
            'city' => $customValidation,
            'postal_code' => $customValidation,
            // 'stripeToken' => 'required_with_all:email,phone,first_name,last_name,address,country,state,city,postal_code',
        ], ['training.date' => 'Field data is not valid']);
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

    public function trialCompleted()
    {
        return view('payment-page');
    }

    public function continuePremium(Request $request)
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
                $price_id = $user->subscriptionDetails->subscription_plan_price_id;
                $subscription = $stripe->subscriptions->create([
                    'customer' => $customer->id,
                    'items' => [['price' => $price_id]],
                ]);
                $stripedata = $stripe->subscriptions->retrieve($subscription->id, []);
                $this->updateSubscriptionDetails($user, $stripedata->id, $customer->id);
                return redirect('/dashboard')->with('msg_success', 'Subscription completed successfully.');
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                return view('payment-page')->with('msg_error', $msg);
            }
        }
    }

    public function updateSubscriptionDetails($user, $subscription_id, $customer_id)
    {
        $user->subscriptionDetails->update([
            'stripe_subscription_id' => $subscription_id,
            'stripe_customer_id' => $customer_id,
        ]);
        $user->userSubscriptionInfo->update(['is_subscribed' => true]);
    }

    public function cancelSubscription()
    {
        $user = Auth::user();
        $sub_id = $user->subscriptionDetails->stripe_subscription_id;
        $stripe = new \Stripe\StripeClient('sk_test_51P6SBB09tId2vnnum7ibbbCIHgacCrrJc1G78LXEYK81LKH0lfMgmVcAzFQySdadJok5xnOwRvEVNqw9m1aiV0qi00Kihjo2GB');
        $stripe->subscriptions->cancel($sub_id, []);
        $user->userSubscriptionInfo->update(['is_subscribed' => false]);
        Mail::to($user->email)->send(new CancelSubscriptionMail());
        return back()->with(['msg_success', 'Subscription cancled!']);
    }

    public function storeWebhookData(Request $request)
    {
        if (data_get($request, 'data.object.object') === 'charge' && data_get($request, 'type') !== 'charge.refunded') {
            $subscriptionDetails = SubscriptionDetails::where('stripe_customer_id', data_get($request, 'data.object.customer'))->first();
            $user = User::find($subscriptionDetails->user_id);
            if ($user && data_get($request, 'type') === 'charge.succeeded' && data_get($request, 'data.object.description') !== 'card-testing') {
                PaymentDetail::create([
                    'user_id' => $user->id,
                    'amount' => data_get($request, 'data.object.amount_captured') / 100,
                    'payment_date' => date('Y-m-d H:i:s', data_get($request, 'created')),
                ]);
                $user->userSubscriptionInfo->update(['is_subscribed' => true, 'trials_completed' => true]);
            }
            if (data_get($request, 'type') === 'charge.failed' && data_get($request, 'data.object.description') !== 'card-testing') {
                $user->userSubscriptionInfo->update(['is_subscribed' => false, 'trials_completed' => true]);
            }
        }
    }

    public function paymentHistory()
    {

    }
}
