<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TestController;
use App\Models\PaymentDetail;
use App\Models\SubscriptionDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
| --------------------------------------------------------------------------
| Web Routes
| --------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/migrate', function () {
    Artisan::call('migrate', [
        // '--path' => '/database/migrations/2024_04_06_020733_create_customers_table.php',
        '--force' => true,
        // '--seed' => true,
    ]);
    // Artisan::call('cache:clear');
    dd('migrate!');
});

Route::group(['middleware' => 'guest'], function () {
    Route::view('/terms-and-condition', 'terms-and-condition');
    Route::view('/privacy-policy', 'privacy-policy');
    Route::view('/', 'front-pages/homepage')->name("index");
    Route::view('/about', 'front-pages/about')->name("about");
    Route::view('/verification', 'front-pages/verification')->name("verification");
    Route::view('/origination', 'front-pages/originations')->name("origination");
    Route::view('/platform', 'front-pages/platform')->name("platform");
    Route::view('/closing', 'front-pages/closing')->name("closing");
    Route::view('/login', 'auth.login')->name("login");
    Route::post('/do-login', [AuthController::class, 'doLogin']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/doRegister', [AuthController::class, 'doRegister']);
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendForgotPasswordLink'])->name('password.email');
    Route::get('/password/reset/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::get('/set-password/{token}', [AuthController::class, 'sePassword'])->name('set.password');
    Route::get('/user-register', [AuthController::class, 'userRegister'])->name('user.register');
});
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
Route::post('/set-password-new-user', [AuthController::class, 'setPasswordForNewUsers']);
Route::get('/logout', [AuthController::class, 'logout']);

//Email verification links
Route::get('/user-register', [AuthController::class, 'userRegister'])->name('user.register');
Route::get('/borrower-register', [AuthController::class, 'userRegister'])->middleware('auth')->name('borrower.register');
Route::get('/email/verify', [AuthController::class, 'notifyEmailVerification'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerificationHandler'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'emailVerificationResend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//Password reset routes
//Authentication required roots

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/logout-from-this-user', [SuperAdminController::class, 'ReLoginFrom']);
    Route::middleware(['isPasswordExpired', 'subscription'])->group(function () {
        Route::view('email', 'deal-email');
        Route::get('/dashboard', [HomeController::class, 'dashboard']);
        Route::get('/home', [HomeController::class, 'dashboard']);
        Route::get('/show-docx/{media}', [HomeController::class, 'showDocx']);
        // Gmail attachments download and other routes
        Route::get('/gmail/auth', [GmailController::class, 'authenticate']);
        Route::get('/gmail/callback', [GmailController::class, 'callback']);
        Route::get('/gmail-inbox', [GmailController::class, 'getGmailInbox']);
        Route::get('/gmail/download/{messageId}/attachments/{attachmentId}/{attachmentIndexId}', [GmailController::class, 'downloadAttachment'])->name('download');
    });
    Route::get('premium-confirmation', [SubscriptionController::class, 'trialCompleted']);
    Route::get('continue-to-premium', [SubscriptionController::class, 'continuePremium']);
    Route::post('continue-stripe-payment', [SubscriptionController::class, 'processPaymentWithStripe']);
});
Route::get('password-expired', [AuthController::class, 'passwordExpired'])
    ->name('password.expired');
Route::post('password-expired', [AuthController::class, 'expiredPasswordUpdate'])
    ->name('password.post_expired');
//=====================Test Routes==================
Route::get('/test', [TestController::class, 'test']);
Route::post('/webhook-charge-succeed', function (Request $request) {
    Log::info($request);
    Log::info(data_get($request, 'type'));

    Log::info(data_get($request, 'data.object.customer'));
});

Route::get('testing', function () {
    $event = array(
        'id' => 'evt_1PGKIi09tId2vnnuyzXwtnke',
        'object' => 'event',
        'api_version' => '2024-04-10',
        'created' => 1715689068,
        'data' => array(
            'object' => array(
                'id' => 'sub_1PGKIh09tId2vnnutChLCfZz',
                'object' => 'subscription',
                'application' => null,
                'application_fee_percent' => null,
                'automatic_tax' => array(
                    'enabled' => false,
                    'liability' => null,
                ),
                'billing_cycle_anchor' => 1716293867,
                'billing_cycle_anchor_config' => null,
                'billing_thresholds' => null,
                'cancel_at' => null,
                'cancel_at_period_end' => false,
                'canceled_at' => null,
                'cancellation_details' => array(
                    'comment' => null,
                    'feedback' => null,
                    'reason' => null,
                ),
                'collection_method' => 'charge_automatically',
                'created' => 1715689067,
                'currency' => 'usd',
                'current_period_end' => 1716293867,
                'current_period_start' => 1715689067,
                'customer' => 'cus_Q6XNcJj10Sjsnj',
                'days_until_due' => null,
                'default_payment_method' => null,
                'default_source' => null,
                'default_tax_rates' => array(
                ),
                'description' => null,
                'discount' => null,
                'discounts' => array(
                ),
                'ended_at' => null,
                'invoice_settings' => array(
                    'account_tax_ids' => null,
                    'issuer' => array(
                        'type' => 'self',
                    ),
                ),
                'items' => array(
                    'object' => 'list',
                    'data' => array(
                        0 => array(
                            'id' => 'si_Q6XNzjmJF1TLFv',
                            'object' => 'subscription_item',
                            'billing_thresholds' => null,
                            'created' => 1715689067,
                            'discounts' => array(
                            ),
                            'metadata' => array(
                            ),
                            'plan' => array(
                                'id' => 'price_1PDhk109tId2vnnueRGJ22ef',
                                'object' => 'plan',
                                'active' => true,
                                'aggregate_usage' => null,
                                'amount' => 50000,
                                'amount_decimal' => '50000',
                                'billing_scheme' => 'per_unit',
                                'created' => 1715064189,
                                'currency' => 'usd',
                                'interval' => 'month',
                                'interval_count' => 1,
                                'livemode' => false,
                                'metadata' => array(
                                ),
                                'meter' => null,
                                'nickname' => null,
                                'product' => 'prod_Q3pOGHwHgQtx4o',
                                'tiers_mode' => null,
                                'transform_usage' => null,
                                'trial_period_days' => null,
                                'usage_type' => 'licensed',
                            ),
                            'price' => array(
                                'id' => 'price_1PDhk109tId2vnnueRGJ22ef',
                                'object' => 'price',
                                'active' => true,
                                'billing_scheme' => 'per_unit',
                                'created' => 1715064189,
                                'currency' => 'usd',
                                'custom_unit_amount' => null,
                                'livemode' => false,
                                'lookup_key' => null,
                                'metadata' => array(
                                ),
                                'nickname' => null,
                                'product' => 'prod_Q3pOGHwHgQtx4o',
                                'recurring' => array(
                                    'aggregate_usage' => null,
                                    'interval' => 'month',
                                    'interval_count' => 1,
                                    'meter' => null,
                                    'trial_period_days' => null,
                                    'usage_type' => 'licensed',
                                ),
                                'tax_behavior' => 'unspecified',
                                'tiers_mode' => null,
                                'transform_quantity' => null,
                                'type' => 'recurring',
                                'unit_amount' => 50000,
                                'unit_amount_decimal' => '50000',
                            ),
                            'quantity' => 1,
                            'subscription' => 'sub_1PGKIh09tId2vnnutChLCfZz',
                            'tax_rates' => array(
                            ),
                        ),
                    ),
                    'has_more' => false,
                    'total_count' => 1,
                    'url' => '/v1/subscription_items?subscription=sub_1PGKIh09tId2vnnutChLCfZz',
                ),
                'latest_invoice' => 'in_1PGKIh09tId2vnnulTpKP5ew',
                'livemode' => false,
                'metadata' => array(
                ),
                'next_pending_invoice_item_invoice' => null,
                'on_behalf_of' => null,
                'pause_collection' => null,
                'payment_settings' => array(
                    'payment_method_options' => null,
                    'payment_method_types' => null,
                    'save_default_payment_method' => 'off',
                ),
                'pending_invoice_item_interval' => null,
                'pending_setup_intent' => null,
                'pending_update' => null,
                'plan' => array(
                    'id' => 'price_1PDhk109tId2vnnueRGJ22ef',
                    'object' => 'plan',
                    'active' => true,
                    'aggregate_usage' => null,
                    'amount' => 50000,
                    'amount_decimal' => '50000',
                    'billing_scheme' => 'per_unit',
                    'created' => 1715064189,
                    'currency' => 'usd',
                    'interval' => 'month',
                    'interval_count' => 1,
                    'livemode' => false,
                    'metadata' => array(
                    ),
                    'meter' => null,
                    'nickname' => null,
                    'product' => 'prod_Q3pOGHwHgQtx4o',
                    'tiers_mode' => null,
                    'transform_usage' => null,
                    'trial_period_days' => null,
                    'usage_type' => 'licensed',
                ),
                'quantity' => 1,
                'schedule' => null,
                'start_date' => 1715689067,
                'status' => 'trialing',
                'test_clock' => null,
                'transfer_data' => null,
                'trial_end' => 1716293867,
                'trial_settings' => array(
                    'end_behavior' => array(
                        'missing_payment_method' => 'create_invoice',
                    ),
                ),
                'trial_start' => 1715689067,
            ),
        ),
        'livemode' => false,
        'pending_webhooks' => 1,
        'request' => array(
            'id' => 'req_4Bf2Fucld975BM',
            'idempotency_key' => '006701d5-19cf-4adf-a6d6-3ea0c33fb1b8',
        ),
        'type' => 'customer.subscription.created',
    );
    if (data_get($event, 'type') === 'charge.succeeded' && data_get($event, 'data.object.customer') !== 'card-testing') {
        $subscriptionDetails = SubscriptionDetails::where('stripe_customer_id', data_get($event, 'data.object.customer'))->first();
        $user = User::find($subscriptionDetails->user_id);
        PaymentDetail::create([
            'user_id' => $user->id,
            'amount' => data_get($event, 'data.object.amount_captured') / 100,
            'payment_date' => now(),
        ]);
    }
    dd(data_get($event, 'type'));
});
Route::view('/trial', 'trial')->name("trial");
Route::get('/trial-custom-quote', function () {
    return view('trial')->with(['customquotesubmited' => 'Your form submitted successfully']);
});
Route::get('/payment-success', [SubscriptionController::class, 'StripeSuccess'])->name("success");
Route::post('/custome-quote', [SubscriptionController::class, 'CustomQuote'])->name("custom.quote");
Route::get('/payment-failed', [SubscriptionController::class, 'StripeFailed'])->name("failed");
Route::post('trial', [SubscriptionController::class, 'processPayment'])->name('stripePayment');
// Route::middleware('trial',function(){
Route::get('/trial-dashboard', [SubscriptionController::class, 'trialDashboard'])->name("trial.dashboard");
Route::get('/subscribe', [SubscriptionController::class, 'finishTrial']);
Route::view('homepage', 'homepage');
// });
// Route::get('success', [SubscriptionController::class, 'success'])->name('payment_success');
// Route::get('cancel', [SubscriptionController::class, 'cancel'])->name('payment_cancel');
