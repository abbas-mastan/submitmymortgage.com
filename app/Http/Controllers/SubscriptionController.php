<?php

namespace App\Http\Controllers;

use App\Helpers\SubscriptionHelper;
use App\Mail\AdminMail;
use App\Mail\CancelSubscriptionMail;
use App\Mail\CustomQuoteMail;
use App\Models\Company;
use App\Models\CustomQuote;
use App\Models\DiscountCode;
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
use Illuminate\Support\Facades\Log;
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

        $array = array(
            'id' => 'evt_3PeC4L09tId2vnnu0i9P76CP',
            'object' => 'event',
            'api_version' => '2024-04-10',
            'created' => 1721377297,
            'data' => array(
                'object' => array(
                    'id' => 'ch_3PeC4L09tId2vnnu0C0rGc2B',
                    'object' => 'charge',
                    'amount' => 100,
                    'amount_captured' => 100,
                    'amount_refunded' => 0,
                    'application' => null,
                    'application_fee' => null,
                    'application_fee_amount' => null,
                    'balance_transaction' => 'txn_3PeC4L09tId2vnnu0Au0cCOo',
                    'billing_details' => array(
                        'address' => array(
                            'city' => null,
                            'country' => null,
                            'line1' => null,
                            'line2' => null,
                            'postal_code' => null,
                            'state' => null,
                        ),
                        'email' => null,
                        'name' => null,
                        'phone' => null,
                    ),
                    'calculated_statement_descriptor' => 'Stripe',
                    'captured' => true,
                    'created' => 1721377297,
                    'currency' => 'usd',
                    'customer' => 'cus_QVCTcrKqwM4jwY',
                    'description' => 'card-testing',
                    'destination' => null,
                    'dispute' => null,
                    'disputed' => false,
                    'failure_balance_transaction' => null,
                    'failure_code' => null,
                    'failure_message' => null,
                    'fraud_details' => array(
                    ),
                    'invoice' => null,
                    'livemode' => false,
                    'metadata' => array(
                    ),
                    'on_behalf_of' => null,
                    'order' => null,
                    'outcome' => array(
                        'network_status' => 'approved_by_network',
                        'reason' => null,
                        'risk_level' => 'normal',
                        'risk_score' => 12,
                        'seller_message' => 'Payment complete.',
                        'type' => 'authorized',
                    ),
                    'paid' => true,
                    'payment_intent' => null,
                    'payment_method' => 'card_1PeC4I09tId2vnnujFcvebc4',
                    'payment_method_details' => array(
                        'card' => array(
                            'amount_authorized' => 100,
                            'brand' => 'visa',
                            'checks' => array(
                                'address_line1_check' => null,
                                'address_postal_code_check' => null,
                                'cvc_check' => 'pass',
                            ),
                            'country' => 'US',
                            'exp_month' => 11,
                            'exp_year' => 2055,
                            'extended_authorization' => array(
                                'status' => 'disabled',
                            ),
                            'fingerprint' => 'LfRQq8DvPNlVTGV2',
                            'funding' => 'credit',
                            'incremental_authorization' => array(
                                'status' => 'unavailable',
                            ),
                            'installments' => null,
                            'last4' => '1111',
                            'mandate' => null,
                            'multicapture' => array(
                                'status' => 'unavailable',
                            ),
                            'network' => 'visa',
                            'network_token' => array(
                                'used' => false,
                            ),
                            'overcapture' => array(
                                'maximum_amount_capturable' => 100,
                                'status' => 'unavailable',
                            ),
                            'three_d_secure' => null,
                            'wallet' => null,
                        ),
                        'type' => 'card',
                    ),
                    'receipt_email' => null,
                    'receipt_number' => null,
                    'receipt_url' => 'https://pay.stripe.com/receipts/payment/CAcaFwoVYWNjdF8xUDZTQkIwOXRJZDJ2bm51KJLE6LQGMga8PP3iW4U6LBZ4P2Sb-IMT1aJBMLnQb76Chg9EWCMSR0HjQz4T34pRBerhpyZChweqyCA2',
                    'refunded' => false,
                    'review' => null,
                    'shipping' => null,
                    'source' => array(
                        'id' => 'card_1PeC4I09tId2vnnujFcvebc4',
                        'object' => 'card',
                        'address_city' => null,
                        'address_country' => null,
                        'address_line1' => null,
                        'address_line1_check' => null,
                        'address_line2' => null,
                        'address_state' => null,
                        'address_zip' => null,
                        'address_zip_check' => null,
                        'brand' => 'Visa',
                        'country' => 'US',
                        'customer' => 'cus_QVCTcrKqwM4jwY',
                        'cvc_check' => 'pass',
                        'dynamic_last4' => null,
                        'exp_month' => 11,
                        'exp_year' => 2055,
                        'fingerprint' => 'LfRQq8DvPNlVTGV2',
                        'funding' => 'credit',
                        'last4' => '1111',
                        'metadata' => array(
                        ),
                        'name' => null,
                        'tokenization_method' => null,
                        'wallet' => null,
                    ),
                    'source_transfer' => null,
                    'statement_descriptor' => null,
                    'statement_descriptor_suffix' => null,
                    'status' => 'succeeded',
                    'transfer_data' => null,
                    'transfer_group' => null,
                ),
            ),
            'livemode' => false,
            'pending_webhooks' => 1,
            'request' => array(
                'id' => 'req_ONkpBoxsFGYelO',
                'idempotency_key' => '2fb18879-d44f-48dd-81ce-84e1b8d3785e',
            ),
            'type' => 'charge.succeeded',
        );

        dd(data_get($array, 'data.object.description'));

        $subscriptionDetails = SubscriptionDetails::where('stripe_customer_id', data_get($array, 'data.object.customer'))->first();
        $user = User::find($subscriptionDetails->user_id);
        dd(data_get($array, 'type'));

        dd(data_get($array, 'data.object.id'));

        $charge = $stripe->charges->retrieve('ch_3PdnU109tId2vnnu0tZbGq85', []);
        dd($charge);

        $coupen = $stripe->coupons->create([
            'duration' => 'forever',
            // 'duration_in_months' => 3,
            'percent_off' => 20,
        ]);
        dd($coupen);
        die;

    }

    public function processPayment(Request $request)
    {
        $validator = $this->ValidateUser($request);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            DB::beginTransaction();
            try {
                $stripe = new \Stripe\StripeClient(env('STRIPE_SK'));
                $webHook = $stripe->webhookEndpoints->all(['limit' => 3]);
                if (empty($webHook->data)) {
                    $stripe->webhookEndpoints->create([
                        'enabled_events' => ['charge.succeeded', 'charge.failed', 'charge.refunded'],
                        'url' => 'https://submitmymortgage.com/charge-webhook',
                    ]);
                }

                $configPlan = config('smm.subscription_plans');
                $subscriptionPlan = SubscriptionPlans::create([
                    'name' => $request->team_size,
                    'stripe_price_id' => rand(15, 100),
                    'trial_days' => env("SUBSCRIPTION_TRIAL_DAYS", 14),
                    'amount' => $configPlan[$request->team_size]['amount'],
                    'max_users' => $configPlan[$request->team_size]['max_users'],
                ]);

                // create company with users starts
                $user = $this->createUserWithCompany($request, $subscriptionPlan->max_users);
                // create company with users end
                $user_id = $user->id;
                if (!$user->subscriptionDetails) {
                    $subscription = SubscriptionPlans::where('name', $request->team_size)->first();
                    SubscriptionDetails::create([
                        'user_id' => $user_id,
                        'status' => 'active',
                        'plan_amount' => $subscription->amount,
                        'plan_interval' => $configPlan[$request->team_size]['interval'],
                        'subscription_plan_price_id' => $subscription->stripe_price_id,
                    ]);
                }

                SubscriptionHelper::userTraining($request, $user_id);
                $id = Crypt::encryptString($user_id);
                DB::table('password_resets')->insert(['email' => $user->email, 'token' => Hash::make(Str::random(12)), 'created_at' => now()]);
                $url = function () use ($id) {return URL::signedRoute('user.register', ['user' => $id], now()->addMinutes(10));};
                Mail::to($request->email)->send(new AdminMail($url()));
                SubscriptionHelper::insertSubscriptionInfo($user_id);
                SubscriptionHelper::insertPersonalInfo($request, $user);

                $company = $user->company;
                $company->created_by = $user_id;
                $company->subscription_id = $user->subscriptionDetails->stripe_subscription_id ?? '';
                $company->save();

                if ($user->email_verified_at == null) {
                    DB::commit();
                    $this->loginwithid($user->id);
                    return response()->json('redirect');
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
        CustomQuote::create(['plan_type' => $request->team_size === 'yearly-plan-6' ? 'yearly' : 'monthly', 'user_id' => $user->id]);
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
            'have_discount_code' => '',
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

    public function continueSignup()
    {
        return view('continue-signup');
    }

    public function continuePremium(Request $request)
    {

        $user = Auth::user();
        $code = DiscountCode::where('code', $request->discount_code)->where('is_used', false)->first();
        $discountCodeValidation = function ($attribute, $value, $fail) use ($request, $code) {
            if ($request->have_discount_code != '') {
                if (!$code) {
                    $fail('The discount code is not available.');
                } else {
                    $request['coupon'] = $code->coupon_code;
                }
            }
        };
        $request->validate([
            'have_discount_code' => '',
            'discount_code' => [$discountCodeValidation],
        ]);

        $stripe = new StripeClient(env('STRIPE_SK'));
        if ($request->stripeToken) {
            try {
                $subscription = SubscriptionPlans::where('stripe_price_id', $user->subscriptionDetails->subscription_plan_price_id)->first();
                if ($subscription) {
                    try {
                        $product = $stripe->prices->retrieve($subscription->stripe_price_id, []);
                    } catch (\Exception $ex) {
                        $product = SubscriptionHelper::createStripeProduct($stripe, $subscription->name, ($subscription->amount * 100), $subscription->id > 5 ? 'yearly' : 'monthly');
                        $subscription->update([
                            'stripe_price_id' => $product->id,
                        ]);
                        $user->subscriptionDetails->update([
                            'subscription_plan_price_id' => $product->id,
                        ]);
                    }
                }

                $request['email'] = $user->email;
                $customer = SubscriptionHelper::charge($request);
                SubscriptionHelper::insertCardDetails($request, $customer->id, $user->id);
                $subscription = SubscriptionHelper::startTrialSubscription($customer->id, $user->id, $subscription);
                if ($customer instanceof \Stripe\Customer) {
                    if ($request->coupon > 0) {
                        $discountCode = DiscountCode::where('code', $request->discount_code)->first();
                        $discountCode->is_used = true;
                        $discountCode->save();
                    }
                }

                $stripedata = $stripe->subscriptions->retrieve($subscription->id, []);
                $this->updateSubscriptionDetails($user, $stripedata->id, $customer->id);
                $user->company->update([
                    'subscription_id' => $subscription->id,
                ]);
                return redirect('/dashboard')->with('msg_success', 'Subscription completed successfully.');
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                return back()->with('msg_error', $msg);
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
            return back()->with('msg_error', 'An error occured:' . $ex->getMessage());
        }
    }

    public function storeWebhookData(Request $request)
    {
        try {
            if (data_get($request, 'data.object.object') === 'charge' && data_get($request, 'type') !== 'charge.refunded') {
                $subscriptionDetails = SubscriptionDetails::where('stripe_customer_id', data_get($request, 'data.object.customer'))->first();
                $user = User::find($subscriptionDetails->user_id);
                if ($user && $request['type'] === 'charge.succeeded' && $request['data']['object']['description'] !== 'card-testing') {
                    PaymentDetail::updateOrCreate([
                        'user_id' => $user->id,
                        'charge_id' => data_get($request, 'data.object.id'),
                    ], [
                        'user_id' => $user->id,
                        'amount' => data_get($request, 'data.object.amount_captured') / 100,
                        'payment_date' => now(),
                        'charge_id' => data_get($request, 'data.object.id'),
                    ]);
                    $user->userSubscriptionInfo->update(['is_subscribed' => true, 'trials_completed' => true]);
                    $company = Company::find($user->company_id);
                    User::where('company_id', $company->id)->update(['active' => true]);
                    $company->update(['enable' => true]);
                }
                if ($user && data_get($request, 'type') === 'charge.failed' && data_get($request, 'data.object.description') !== 'card-testing') {
                    User::where('company_id', $user->company_id)->update(['active' => false]);
                    $user->company->update([
                        'enbale' => false,
                    ]);
                    $user->userSubscriptionInfo->update(['is_subscribed' => false, 'trials_completed' => true]);
                }
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Log::info($request);
        }
    }

    public function getDiscount($code)
    {
        $discount = DiscountCode::where('code', $code)->where('is_used', false)->first(['code', 'discount_type', 'discount']);
        return response()->json($discount ?? 'code-not-found');
    }

}
