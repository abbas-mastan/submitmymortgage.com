<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
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
// Route::get('/migrate', function(){
//     \Illuminate\Support\Facades\Artisan::call('migrate');
//     dd('migrated!');
// });

Route::view('/terms-and-condition', 'terms-and-condition');
Route::view('/privacy-policy', 'privacy-policy');
Route::view('/', 'index')->name("index");
Route::view('/login', 'auth.login')->name("login");
Route::post('/do-login', [AuthController::class, 'doLogin']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/doRegister', [AuthController::class, 'doRegister']);
//Email verification links
Route::get('/email/verify', [AuthController::class, 'notifyEmailVerification'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'emailVerificationHandler'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'emailVerificationResend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//Password reset routes
Route::get(
    '/forgot-password',
    [AuthController::class, 'forgotPassword']
)
    ->middleware('guest')
    ->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendForgotPasswordLink'])
    ->middleware('guest')
    ->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'updatePassword'])
    ->middleware('guest')
    ->name('password.update');
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
