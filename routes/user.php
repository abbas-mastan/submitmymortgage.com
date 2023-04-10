<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth','user','verified'])->prefix(getUserRoutePrefix())->group(function () {
     //==============================
    //==========Files related routes
    //==============================
    Route::post('/file-upload', [UserController::class,'fileUpload']);
    // Route::get('/credit-report', [UserController::class,'creditReport']);
    Route::get('/bank-statement', [UserController::class,'bankStatement']);
    Route::get('/pay-stub', [UserController::class,'payStub']);
    Route::get('/tax-return', [UserController::class,'taxReturn']);
    Route::get('/id-license', [UserController::class,'idLicense']);
    Route::get('/1003', [UserController::class,'_1003']);
    Route::get('/miscellaneous', [UserController::class,'miscellaneous']);
    Route::get('/mortgage-statement', [UserController::class,'mortgageStatement']);
    Route::get('/insurance-evidence', [UserController::class,'insuranceEvidence']);
    Route::get('/purchase-agreement', [UserController::class,'purchaseAgreement']);
    Route::get('/delete-file/{id}', [AdminController::class,'deleteFile']);
    Route::get('/basic-info', [UserController::class,'basicInfo']);
    Route::post('/do-info', [UserController::class,'doInfo']);
    Route::get('/application-status', [UserController::class,'applicationStatus']);
    Route::post('/update-cat-comments', [UserController::class,'updateCatComments']);
    //==============================
    //==========Profile related routes
    //==============================
    
    Route::get('/profile', [UserController::class,'profile']);
    Route::post('/do-profile', [UserController::class,'doProfile']);
    Route::post('/do-user/-1', [UserController::class,'doUser']);
    //Meeting related routes
    //  Route::get('/start-meeting/{meetingId}', [MeetingController::class,'startMeeting']);
});

//================================
//===========Publically accessible course purchasing routes
//================================

Route::prefix(getUserRoutePrefix())->group(function () {
    Route::get('/course-selection', [StudentController::class,'courseSelection']);
});