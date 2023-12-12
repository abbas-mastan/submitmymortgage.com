<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController,HomeController,SuperAdminController,};

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
//if(!Gate::allows('isAdmin'))
//{
//    abort(403);
//}
Route::middleware(['auth', 'superadmin'])->prefix(getSuperAdminRoutePrefix())->group(function () {
    //==============================
    //==========User related routes
    //==============================
    Route::get('/users', [SuperAdminController::class, 'users']);
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/add-user/{userId}', [SuperAdminController::class, 'addUser']);
    Route::post('/do-user/{userId}', [SuperAdminController::class, 'doUser']);
    Route::get('/delete-user/{userId}', [SuperAdminController::class, 'deleteUser']);
    Route::get('/delete-user-permenant/{user}', [SuperAdminController::class, 'deleteUserPermenant'])->withTrashed();
    Route::get('/restore-user/{user}', [SuperAdminController::class, 'restoreUser'])->withTrashed();
    Route::get('/verify-user/{user}', [SuperAdminController::class, 'verifyUser']);
    //==============================
    //==========Files related routes
    //==============================
    Route::get('/file-cat/{id}', [SuperAdminController::class, 'filesCat']);
    Route::get('/files/{id?}', [SuperAdminController::class, 'files']);
    Route::get('/docs/{id}/{cat}', [SuperAdminController::class, 'docs']);
    Route::get('/update-file-status/{fileId}', [SuperAdminController::class, 'updateFileStatus']);
    Route::post('/update-category-status', [SuperAdminController::class, 'updateCategoryStatus']);
    Route::post('/update-cat-comments/{cat}', [SuperAdminController::class, 'updateCatComments']);
    Route::get('/delete-file/{id}', [SuperAdminController::class, 'deleteFile']);
    Route::post('/file-upload', [SuperAdminController::class, 'fileUpload']);
    Route::get('/application/{id?}', [SuperAdminController::class, 'application']);
    Route::get('/applications', [SuperAdminController::class, 'applications']);
    Route::post('/do-application', [SuperAdminController::class, 'doApplication']);
    Route::get('/application-show/{application}', [SuperAdminController::class, 'applicationShow']);
    Route::get('/application-edit/{application}', [SuperAdminController::class, 'applicationEdit']);
    Route::post('/application-update/{application}', [SuperAdminController::class, 'applicationUpdate']);
    Route::get('/application-update-status/{application}/{status?}', [SuperAdminController::class, 'applicationUpdateStatus']);
    Route::get('/application-delete/{application}', [SuperAdminController::class, 'deleteApplication']);
    Route::get('/leads', [SuperAdminController::class, 'allLeads']);
    Route::get('/lead/{user}', [SuperAdminController::class, 'lead']);
    Route::get('/delete-lead/{info}', [SuperAdminController::class, 'deleteLead']);
    Route::get('/basic-info', [SuperAdminController::class, 'basicInfo']);
    Route::post('/do-info', [UserController::class, 'doInfo']);
    #all users
    Route::get('/all-users/{id?}', [SuperAdminController::class, 'allUsers']);
    Route::get('/hide-cat/{user}/{cat}', [SuperAdminController::class, 'hideCategory'])->where('cat', '(.*)');
    Route::post('/login-as-this-user', [SuperAdminController::class, 'LoginAsThisUser']);
    Route::post('/add-category/{user?}', [SuperAdminController::class, 'addCategoryToUser']);
    Route::get('/delete-category/{user?}/{cat}', [SuperAdminController::class, 'deleteCategory']);
    //==============================
    //==========Profile related routes
    //==============================
    Route::get('/profile', [SuperAdminController::class, 'profile']);
    Route::post('/do-profile', [SuperAdminController::class, 'doProfile']);

    Route::get('/disconnect-google', [SuperAdminController::class, 'disconnectGoogle'])->name('disconnect.google');
    Route::get('/excel', [SuperAdminController::class, 'excel']);
    Route::post('/spreadsheet', [SuperAdminController::class, 'spreadsheet']);
    Route::get('/upload-files', [SuperAdminController::class, 'uploadFilesView']);
    Route::post('/upload-files', [SuperAdminController::class, 'uploadFiles']);
    Route::get('/delete-attachment/{id}', [SuperAdminController::class, 'deleteAttachment']);

    Route::post('/export-contacts', [SuperAdminController::class, 'exportContactsToExcel']);

    //=============================================
    //=============> new Design Routes
    //=============================================
    Route::get('projects', [SuperAdminController::class, 'projects']);
    Route::post('store-project', [SuperAdminController::class, 'storeProject']);
    Route::get('/getUsersByTeam/{team}', [SuperAdminController::class, 'getUsersByTeam']);
    Route::get('/getUsersByProcessor/{id}/{teamid}', [SuperAdminController::class, 'getUsersByProcessor']);
    Route::get('teams', [SuperAdminController::class, 'teams']);
    Route::get('delete-user-from-team/{team}/{user}', [SuperAdminController::class, 'deleteTeamMember']);
    Route::get('delete-project-user/{project}/{user}', [SuperAdminController::class, 'deleteProjectUser']);
    Route::post('teams/{id?}', [SuperAdminController::class, 'storeteam']);
    Route::get('delete-team/{team}', [SuperAdminController::class, 'deleteTeam']);
    Route::get('new-users', [SuperAdminController::class, 'newusers']);
    Route::get('contacts', [SuperAdminController::class, 'contacts']);
    Route::post('savepdf', [SuperAdminController::class, 'savepdf']);
    Route::get('/delete-contact/{contact}', [SuperAdminController::class, 'deleteContact']);
    Route::post('/do-contact/{id?}', [SuperAdminController::class, 'doContact']);
    Route::get('project-overview/{id?}', [SuperAdminController::class, 'projectOverview']);
    Route::post('/share-items', [SuperAdminController::class, 'shareItemWithAssistant']);
    Route::get('sortby/{id?}/{sortby?}', [SuperAdminController::class, 'projectOverview']);
    // this route is for updating status to disable or close the project
    Route::get('project/{status}/{project}', [SuperAdminController::class, 'changeProjectStatus']);
    // this route is for mark as read the notification
    Route::get('/mark-as-read/{id}', [SuperAdminController::class, 'markAsRead']);
    Route::get('/remove-access/{user}', [SuperAdminController::class, 'removeAcess']);
    Route::post('/submit-intake-form', [SuperAdminController::class, 'submitIntakeForm']);
    Route::post('/do-associate', [SuperAdminController::class, 'doAssociate']);
    Route::post('/get-associates', [SuperAdminController::class, 'getAssociates']);
    Route::get('/redirect/{route}/{message}', [SuperAdminController::class, 'redirectTo']);
    
});
Route::prefix(getRoutePrefix())->group(function () {
    //==============================
    //==========Ajax routes
    //==============================
    //College related stuff
});
