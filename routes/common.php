<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Route::view('confirm-password', 'auth/password-confirm')->name('password.confirm');
Route::post('/confirm-password', function (Request $request) {
    if (!Hash::check($request->password, $request->user()->password)) {
        return back()->withErrors([
            'password' => ['The provided password does not match our records.'],
        ]);
    }
    $request->session()->passwordConfirmed();
    return redirect()->intended();
})->middleware(['throttle:6,1']);

//starts here. these routes are for update profile information
Route::get('/profile',[AdminController::class,'profile'])->name('profile')->middleware('password.confirm');
Route::post('/do-profile', 'doProfile');
//end here. these routes are for update profile information

Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::post('/do-info', [UserController::class, 'doInfo']);

Route::post('/add-category/{user?}', 'addCategoryToUser');
Route::get('/hide-cat/{user}/{cat}', 'hideCategory')->where('cat', '(.*)');
Route::get('/all-users/{id?}', 'allUsers')->name('all-user');
Route::get('/basic-info', 'basicInfo');
Route::get('/delete-lead/{info}', 'deleteLead');
Route::get('/lead/{user}', 'lead');
Route::get('/leads', 'allLeads');
Route::get('/delete-file/{id}', 'deleteFile');
Route::post('/file-upload', 'fileUpload');
Route::get('/application/{id?}', 'application');
Route::get('/applications', 'applications');
Route::post('/do-application', 'doApplication');
Route::get('/application-show/{application}', 'applicationShow');
Route::get('/application-edit/{application}', 'applicationEdit');
Route::post('/application-update/{application}', 'applicationUpdate');
Route::get('/application-update-status/{application}/{status?}', 'applicationUpdateStatus');
Route::get('/application-delete/{application}', 'deleteApplication');
Route::post('/update-cat-comments/{cat}', 'updateCatComments');
Route::get('/update-file-status/{fileId}', 'updateFileStatus');
Route::post('/update-category-status', 'updateCategoryStatus');
Route::get('/file-cat/{id}', 'filesCat');
Route::get('/files/{id?}', 'files');
Route::get('/docs/{id}/{cat}', 'docs');
Route::get('/add-user/{userId}', 'addUser')->name('add-user');
Route::post('/do-user/{userId}', 'doUser');
Route::get('/delete-user/{userId}', 'deleteUser');
Route::get('/redirect/{route}/{message}', 'redirectTo');
Route::get('/intake-update-status/{intake}/{status?}', 'updateIntakeStatus');
Route::get('/loan-intake/{id}', 'loanIntakeShow')->name('loan-intake');
Route::get('/mark-as-read/{id}', 'markAsRead');
Route::get('/remove-access/{user}', 'removeAcess');
Route::post('/submit-intake-form', 'submitIntakeForm');
Route::get('/loan-intake', 'loanIntake');
Route::get('sortby/{id?}/{sortby?}', 'projectOverview');
Route::post('/share-items/{id?}', 'shareItemWithAssistant')->name('share-items');
Route::post('/update-share-items/{id}', 'updateShareItemWithAssistant')->name('update-share-items');
Route::get('project-overview/{id?}', 'projectOverview');
Route::post('/do-contact/{id?}', 'doContact');
Route::get('/delete-contact/{contact}', 'deleteContact');
Route::post('/spreadsheet', 'spreadsheet');
Route::post('/export-contacts', 'exportContactsToExcel');
Route::get('/disconnect-google', 'disconnectGoogle')->name('disconnect.google');
Route::get('/upload-files', 'uploadFilesView');
Route::post('/upload-files', 'uploadFiles');
Route::post('/add-category/{user?}', 'addCategoryToUser');
Route::get('/delete-lead/{info}', 'deleteLead');
Route::get('projects', 'projects');
Route::post('store-project/{id?}  ', 'storeProject');
Route::get('teams', 'teams');
Route::get('/getUsersByTeam/{team}', 'getUsersByTeam');
Route::get('/delete-category/{user?}/{cat}', 'deleteCategory');
Route::get('contacts', 'contacts');
Route::post('teams/{id?}', 'storeteam');
Route::get('/getUsersByProcessor/{id}/{teamid}', 'getUsersByProcessor');
// this route is for updating status to disable or close the project
Route::get('project/{status}/{project}', 'changeProjectStatus');
