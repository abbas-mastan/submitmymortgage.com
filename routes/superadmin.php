<?php

use App\Http\Controllers\AdminCompanyController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Super Admin Routes
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
    Route::group(['controller' => SuperAdminController::class], function () {
        require __DIR__ . '/common.php';
        // This route logging out all users from the site
        Route::get('/logout-all-users', 'logoutAllUsers');

        Route::get('/delete-user-permenant/{user}', 'deleteUserPermenant')->withTrashed();
        Route::get('/restore-user/{user}', 'restoreUser')->withTrashed();
        // this route verify the user email
        Route::get('/verify-user/{user}', 'verifyUser');
    
        Route::post('/login-as-this-user', 'LoginAsThisUser');
        Route::get('/delete-attachment/{id}', 'deleteAttachment');

        //=============================================
        //=============> new Design Routes
        //=============================================
        Route::get('delete-user-from-team/{team}/{user}', 'deleteTeamMember');
        Route::get('delete-project-user/{project}/{user}', 'deleteProjectUser');
        Route::get('delete-team/{team}', 'deleteTeam');
        Route::get('/connections', 'connections');
        Route::get('/delete-connection/{user}', 'deleteConnection');
        Route::post('savepdf', 'savepdf');
        // this route is for updating status to disable or close the project

        Route::post('/do-associate', 'doAssociate');
        Route::post('/get-associates/{company}', 'getAssociates');
        Route::get('/get-company-teams/{company}', 'getCompanyTeams');
        Route::get('/get-company-borrowers/{company}', 'getCompanyBorrowers');
        Route::get('/custom-quote', 'customQuotes');

    });

    // These routes are only useable for Super Admin role
    Route::get('/restore-company/{company}', [AdminCompanyController::class, 'restore'])->withTrashed()->name('company.restore');
    Route::get('/delete-company-permanent/{company}', [AdminCompanyController::class, 'permanent'])->withTrashed();
    Route::get('/companies', [AdminCompanyController::class, 'index']);
    Route::post('/do-company/{id?}', [AdminCompanyController::class, 'store']);
    Route::get('/delete-company/{company}', [AdminCompanyController::class, 'destroy']);
    Route::get('/getUsersByCompany/{company}', [AdminCompanyController::class, 'getUsersByCompany']);

});
