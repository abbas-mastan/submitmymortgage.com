<?php

use App\Http\Controllers\AdminCompanyController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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
    Route::group(['controller' => AdminController::class], function () {
        require __DIR__ . '/common.php';

        // only Super Admin and admin can use these routes
        Route::get('/delete-user-permenant/{user}', 'deleteUserPermenant')->withTrashed();
        Route::get('/restore-user/{user}', 'restoreUser')->withTrashed();
        Route::get('/verify-user/{user}', 'verifyUser');

        //=============================================
        //=============> new Design Routes
        //=============================================
        Route::get('delete-user-from-team/{team}/{user}', 'deleteTeamMember');
        Route::get('delete-project-user/{project}/{user}', 'deleteProjectUser');
        Route::get('delete-team/{team}', 'deleteTeam');
        Route::get('connections', 'connections');
        Route::get('/delete-connection/{user}', 'deleteConnection');
        Route::post('savepdf', 'savepdf');
        Route::post('/do-associate', 'doAssociate');
        Route::post('/get-associates/{company?}', 'getAssociates');
        Route::get('/delete-attachment/{id}', 'deleteAttachment');
        Route::get('/getUsersByCompany/{company}', [AdminCompanyController::class, 'getUsersByCompany']);
    });
});
