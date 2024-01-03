<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminCompanyController;
use App\Http\Controllers\{UserController,HomeController,SuperAdminController,CompanyController};
use App\Http\Middleware\SuperAdminMiddleware;

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
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::post('/do-info', [UserController::class, 'doInfo']);
    Route::group(['controller'=> SuperAdminController::class],function(){
        Route::get('/users', 'users');
        Route::get('/add-user/{userId}', 'addUser');
        Route::post('/do-user/{userId}', 'doUser');
        Route::get('/delete-user/{userId}', 'deleteUser');
    Route::get('/delete-user-permenant/{user}', 'deleteUserPermenant')->withTrashed();
    Route::get('/restore-user/{user}', 'restoreUser')->withTrashed();
    Route::get('/verify-user/{user}', 'verifyUser');
    //==============================
    //==========Files related routes
    //==============================
    Route::get('/file-cat/{id}', 'filesCat');
    Route::get('/files/{id?}', 'files');
    Route::get('/docs/{id}/{cat}', 'docs');
    Route::get('/update-file-status/{fileId}', 'updateFileStatus');
    Route::post('/update-category-status', 'updateCategoryStatus');
    Route::post('/update-cat-comments/{cat}', 'updateCatComments');
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
    Route::get('/leads', 'allLeads');
    Route::get('/lead/{user}', 'lead');
    Route::get('/delete-lead/{info}', 'deleteLead');
    Route::get('/basic-info', 'basicInfo');
    #all users
    Route::get('/all-users/{id?}', 'allUsers');
    Route::get('/hide-cat/{user}/{cat}', 'hideCategory')->where('cat', '(.*)');
    Route::post('/login-as-this-user', 'LoginAsThisUser');
    Route::post('/add-category/{user?}', 'addCategoryToUser');
    Route::get('/delete-category/{user?}/{cat}', 'deleteCategory');
    //==============================
    //==========Profile related routes
    //==============================
    Route::get('/profile', 'profile');
    Route::post('/do-profile', 'doProfile');

    Route::get('/disconnect-google', 'disconnectGoogle')->name('disconnect.google');
    Route::get('/excel', 'excel');
    Route::post('/spreadsheet', 'spreadsheet');
    Route::get('/upload-files', 'uploadFilesView');
    Route::post('/upload-files', 'uploadFiles');
    Route::get('/delete-attachment/{id}', 'deleteAttachment');

    Route::post('/export-contacts', 'exportContactsToExcel');

    //=============================================
    //=============> new Design Routes
    //=============================================
    Route::get('projects', 'projects');
    Route::post('store-project', 'storeProject');
    Route::get('/getUsersByTeam/{team}', 'getUsersByTeam');
    Route::get('/getUsersByProcessor/{id}/{teamid}', 'getUsersByProcessor');
    Route::get('teams', 'teams');
    Route::get('delete-user-from-team/{team}/{user}', 'deleteTeamMember');
    Route::get('delete-project-user/{project}/{user}', 'deleteProjectUser');
    Route::post('teams/{id?}', 'storeteam');
    Route::get('delete-team/{team}', 'deleteTeam');
    Route::get('new-users', 'newusers');
    Route::get('contacts', 'contacts');
    Route::get('/connections', 'connections');
    Route::post('savepdf', 'savepdf');
    Route::get('/delete-contact/{contact}', 'deleteContact');
    Route::post('/do-contact/{id?}', 'doContact');
    Route::get('project-overview/{id?}', 'projectOverview');
    Route::post('/share-items', 'shareItemWithAssistant');
    Route::get('sortby/{id?}/{sortby?}', 'projectOverview');
    // this route is for updating status to disable or close the project
    Route::get('project/{status}/{project}', 'changeProjectStatus');
    // this route is for mark as read the notification
    Route::get('/mark-as-read/{id}', 'markAsRead');
    Route::get('/remove-access/{user}', 'removeAcess');
    Route::post('/submit-intake-form', 'submitIntakeForm');
    Route::post('/do-associate', 'doAssociate');
    Route::post('/get-associates', 'getAssociates');
    Route::get('/redirect/{route}/{message}', 'redirectTo');
});
    
    Route::get('/restore-company/{company}',[AdminCompanyController::class,'restore'])->withTrashed()->name('company.restore');
    Route::get('/delete-company-permanent/{company}',[AdminCompanyController::class,'permanent'])->withTrashed();
    Route::get('/companies',[AdminCompanyController::class,'index']);
    Route::post('/do-company/{id?}',[AdminCompanyController::class,'store']);
    Route::get('/delete-company/{company}',[AdminCompanyController::class,'destroy']);
});