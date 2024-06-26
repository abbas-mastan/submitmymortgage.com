<?php

namespace App\Http\Controllers;

use App\Helpers\SubscriptionHelper;
use App\Mail\AdminMail;
use App\Mail\CancelSubscriptionMail;
use App\Mail\CustomQuoteMail;
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

        $stripe = new StripeClient(env('STRIPE_SK'));
        // $product = $stripe->products->create([
        //     'name' => 'Gold Plan',
        // ]);

        $product = $stripe->prices->create([
            'currency' => 'usd',
            'unit_amount' => 1000,
            'recurring' => ['interval' => 'month'],
            'product_data' => ['name' => 'test plan'],
        ]);
        dd($product);

        die;
        $user = Auth::user();
        $sub_id = $user->subscriptionDetails->stripe_subscription_id;
        $cus_id = $user->subscriptionDetails->stripe_customer_id;
        $price_id = $user->subscriptionDetails->subscription_plan_price_id;
        dump(date('Y-m-d H:i:s', 1718022239));
        dump(date('Y-m-d H:i:s', 1716811898));
        $customer = $stripe->customers->retrieve($cus_id, []);

        $session = $stripe->subscriptions->all([
            'customer' => $cus_id,
            'status' => 'all',
        ]);

        $subscription = $stripe->subscriptions->retrieve($sub_id, []);
        $schedule = $stripe->subscriptionSchedules->create([
            'customer' => $cus_id,
            'start_date' => $subscription->current_period_end,
            'end_behavior' => 'release',
            'phases' => [
                [
                    'items' => [
                        [
                            'price' => $price_id,
                            'quantity' => 1,
                        ],
                    ],
                    'iterations' => 12,
                ],
            ],
        ]);
        dump($schedule);
        echo '<pre>';
        var_dump($session->data);
        echo '</pre>';
        die;

        dump(date('Y-m-d H:i:s', $subscription->current_period_end));
        dump($session);
        dd($session->jsonSerialize());
    }

    public function processPayment(Request $request)
    {
        $validator = $this->ValidateUser($request);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            DB::beginTransaction();
            try {
                $customer = SubscriptionHelper::charge($request);
                if ($customer instanceof \Stripe\Customer) {
                    $subscriptionPlan = SubscriptionPlans::where('name', $request->team_size)->first();
                    // create company with users starts
                    $user = $this->createUserWithCompany($request, $subscriptionPlan->max_users);
                    // create company with users end
                    $customer_id = $customer->id;
                    $user_id = $user->id;
                    SubscriptionHelper::userTraining($request, $user_id);
                    $id = Crypt::encryptString($user_id);
                    DB::table('password_resets')->insert(['email' => $user->email, 'token' => Hash::make(Str::random(12)), 'created_at' => now()]);
                    $url = function () use ($id) {return URL::signedRoute('user.register', ['user' => $id], now()->addMinutes(10));};
                    Mail::to($request->email)->send(new AdminMail($url()));
                    SubscriptionHelper::insertCardDetails($request, $customer_id, $user_id);
                    SubscriptionHelper::insertSubscriptionInfo($user_id);
                    SubscriptionHelper::insertPersonalInfo($request, $user);
                    if ($subscriptionPlan) {
                        $subscriptionData = SubscriptionHelper::startTrialSubscription($customer_id, $user_id, $subscriptionPlan);
                        $company = $user->company;
                        $company->created_by = $user_id;
                        $company->subscription_id = $user->subscriptionDetails->stripe_subscription_id;
                        $company->save();
                    }
                    if ($user->email_verified_at == null && $subscriptionData) {
                        DB::commit();
                        $this->loginwithid($user->id);
                        return response()->json('redirect');
                    }
                } else {
                    return $customer;
                }
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['type' => 'stripe_error', 'message' => $e->getMessage()]);
            }
        }
    }

    protected function createUserWithCompany($request, $max_users)
    {
        $company = Company::create([
            'name' => $request->company,
            'max_users' => $max_users,
        ]);
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
            'phone' => 'required|regex:/^\+1 \(\d{3}\) \d{3}-\d{4}$/',
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
                $user->company->update([
                    'subscription_id' => $subscription->id,
                ]);
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
        $stripe = new \Stripe\StripeClient(env('STRIPE_SK'));
        try {
            $stripe->subscriptions->cancel($sub_id, []);
            $user->userSubscriptionInfo->update(['is_subscribed' => false]);
            Mail::to($user->email)->send(new CancelSubscriptionMail());
            return back()->with(['msg_success', 'Subscription cancled!']);
        } catch (\Exception $ex) {
            return back()->with('msg_error','An error occured:'.$ex->getMessage());
        }
    }

    public function storeWebhookData(Request $request)
    {
        if (data_get($request, 'data.object.object') === 'charge' && data_get($request, 'type') !== 'charge.refunded') {
            $subscriptionDetails = SubscriptionDetails::where('stripe_customer_id', data_get($request, 'data.object.customer'))->first();
            $user = User::find($subscriptionDetails->user_id);
            if ($user && data_get($request, 'type') === 'charge.succeeded' && data_get($request, 'data.object.description') !== 'card-testing') {
                $old_payment = $user->payments()->orderby('created_at', 'desc')->first();
                $current_payment_date = date('Y-m-d H:i:s', data_get($request, 'created'));
                if ($old_payment->payment_date !== $current_payment_date) {
                    PaymentDetail::create([
                        'user_id' => $user->id,
                        'amount' => data_get($request, 'data.object.amount_captured') / 100,
                        'payment_date' => $current_payment_date,
                    ]);
                    $user->userSubscriptionInfo->update(['is_subscribed' => true, 'trials_completed' => true]);
                    $company = Company::find($user->company_id);
                    User::where('company_id', $company->id)->update(['active' => true]);
                    $company->update(['enable' => true]);
                }
            }
            if ($user && data_get($request, 'type') === 'charge.failed' && data_get($request, 'data.object.description') !== 'card-testing') {
                $company = Company::find($user->company_id);
                User::where('company_id', $company->id)->update(['active' => false]);
                $company->update(['enable' => false]);
                $user->userSubscriptionInfo->update(['is_subscribed' => false, 'trials_completed' => true]);
            }
        }
    }
}
