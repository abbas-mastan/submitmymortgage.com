<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Artisan;
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
    // Artisan::call('migrate',['--path'=> '/database/migrations/2023_08_03_045920_add_soft_deletes_to_users_table','--force'=>true]);
    Artisan::call('cache:clear');
    dd('migrate!');
});

Route::group(['middleware' => 'guest'], function () {
    Route::view('/terms-and-condition', 'terms-and-condition');
    Route::view('/privacy-policy', 'privacy-policy');
    Route::view('/', 'index')->name("index");
    Route::view('/login', 'auth.login')->name("login");
    Route::post('/do-login', [AuthController::class, 'doLogin']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/doRegister', [AuthController::class, 'doRegister']);
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendForgotPasswordLink'])->name('password.email');
    Route::get('/password/reset/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
    Route::get('/set-password/{token}', [AuthController::class, 'sePassword'])->name('set.password');
    Route::get('/user-register', [AuthController::class, 'userRegister'])->name('user.register');
    Route::post('/set-password-new-user', [AuthController::class, 'setPasswordForNewUsers']);

});
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
    Route::middleware(['isPasswordExpired'])->group(function () {
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
});
Route::get('password-expired', [AuthController::class, 'passwordExpired'])
    ->name('password.expired');
Route::post('password-expired', [AuthController::class,'expiredPasswordUpdate'])
    ->name('password.post_expired');
//=====================Test Routes==================
Route::get('/test', [TestController::class, 'test']);
