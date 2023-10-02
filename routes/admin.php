<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

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
Route::middleware(['auth', 'admin'])->prefix(getAdminRoutePrefix())->group(function () {
  //==============================
  //==========User related routes
  //==============================
  Route::get('/users', [AdminController::class, 'users']);
  Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
  Route::get('/add-user/{userId}', [AdminController::class, 'addUser']);
  Route::post('/do-user/{userId}', [AdminController::class, 'doUser']);
  Route::get('/delete-user/{userId}', [AdminController::class, 'deleteUser']);
  Route::get('/delete-user-permenant/{user}',[AdminController::class, 'deleteUserPermenant'])->withTrashed();
  Route::get('/restore-user/{user}',[AdminController::class, 'restoreUser'])->withTrashed();
  //==============================
  //==========Files related routes
  //==============================
  Route::get('/file-cat/{id}', [AdminController::class, 'filesCat']);
  Route::get('/files/{id?}', [AdminController::class, 'files']);
  Route::get('/docs/{id}/{cat}', [AdminController::class, 'docs']);
  Route::get('/update-file-status/{fileId}', [AdminController::class, 'updateFileStatus']);
  Route::post('/update-category-status', [AdminController::class, 'updateCategoryStatus']);
  Route::post('/update-cat-comments/{cat}', [AdminController::class, 'updateCatComments']);
  Route::get('/delete-file/{id}', [AdminController::class, 'deleteFile']);
  Route::post('/file-upload', [AdminController::class, 'fileUpload']);
  Route::get('/application/{id?}', [AdminController::class, 'application']);
  Route::get('/applications', [AdminController::class, 'applications']);
  Route::post('/do-application', [AdminController::class, 'doApplication']);
  Route::get('/application-show/{application}', [AdminController::class, 'applicationShow']);
  Route::get('/application-edit/{application}', [AdminController::class, 'applicationEdit']);
  Route::post('/application-update/{application}', [AdminController::class, 'applicationUpdate']);
  Route::get('/application-update-status/{application}/{status?}', [AdminController::class, 'applicationUpdateStatus']);
  Route::get('/application-delete/{application}', [AdminController::class, 'deleteApplication']);
  Route::get('/leads', [AdminController::class, 'allLeads']);
  Route::get('/lead/{user}', [AdminController::class, 'lead']);
  Route::get('/delete-lead/{info}', [AdminController::class, 'deleteLead']);
  Route::get('/basic-info', [AdminController::class, 'basicInfo']);
  Route::post('/do-info', [UserController::class, 'doInfo']);
  #all users 
  Route::get('/all-users/{id?}', [AdminController::class, 'allUsers']);
  Route::get('/hide-cat/{user}/{cat}', [AdminController::class, 'hideCategory'])->where('cat', '(.*)');
  Route::post('/login-as-this-user', [AdminController::class, 'LoginAsThisUser']);
  Route::post('/add-category/{user?}', [AdminController::class, 'addCategoryToUser']);
  Route::get('/delete-category/{user?}/{cat}', [AdminController::class, 'deleteCategory']);
  //==============================
  //==========Profile related routes
  //==============================
  Route::get('/profile', [AdminController::class, 'profile']);
  Route::post('/do-profile', [AdminController::class, 'doProfile']);
  Route::get('/disconnect-google', [AdminController::class, 'disconnectGoogle'])->name('disconnect.google');
  Route::get('/excel',[AdminController::class,'excel']);
  Route::post('/spreadsheet',[AdminController::class,'spreadsheet']);
  Route::get('/upload-files',[AdminController::class,'uploadFilesView']);
  Route::post('/upload-files',[AdminController::class,'uploadFiles']);
  Route::post('/export-contacts',[AdminController::class,'exportContactsToExcel']);


  //=============================================
  //=============> new Design Routes 
  //=============================================
  Route::get('projects',[AdminController::class,'projects']);
  Route::post('store-project',[AdminController::class,'storeProject']);
  Route::get('/getUsersByTeam/{id}',[AdminController::class,'getUsersByTeam']);
  Route::get('/getUsersByProcessor/{id}/{teamid}',[AdminController::class,'getUsersByProcessor']);
  Route::get('teams',[AdminController::class,'teams']);
  Route::post('teams/{id?}',[AdminController::class,'storeteam']);
  Route::get('new-users',[AdminController::class,'newusers']);
  Route::get('contacts',[AdminController::class,'contacts']);
  Route::post('/do-contact',[AdminController::class,'doContact']);
  Route::get('project-overview/{id?}',[AdminController::class,'projectOverview']);

});
Route::prefix(getAdminRoutePrefix())->group(function () {
  //==============================
  //==========Ajax routes
  //==============================
  //College related stuff
  Route::get('/get-colleges', [AdminController::class, 'getColleges']);
});
