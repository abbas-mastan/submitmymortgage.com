<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\{Artisan, Route};
use App\Http\Controllers\{GmailController, HomeController, AuthController};

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
    Artisan::call('migrate', ['--force' => true]);
    dd('migrated!');
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
    Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
});
Route::get('/logout', [AuthController::class, 'logout']);
Route::post('/logout-from-this-user', [AdminController::class, 'ReLoginFrom']);

//Email verification links
Route::get('/email/verify', [AuthController::class, 'notifyEmailVerification'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerificationHandler'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'emailVerificationResend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//Password reset routes
//Authentication required roots

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard']);
    Route::get('/home', [HomeController::class, 'dashboard']);
    // Gmail attachments download and other routes
    Route::get('/gmail/auth', [GmailController::class, 'authenticate']);
    Route::get('/gmail/callback', [GmailController::class, 'callback']);
    Route::get('/gmail-inbox', [GmailController::class, 'getGmailInbox']);
    Route::get('/gmail/download/{messageId}/attachments/{attachmentId}/{attachmentIndexId}', [GmailController::class, 'downloadAttachment'])->name('download');
});

//=====================Test Routes==================
Route::get('/test', [TestController::class, 'test']);
