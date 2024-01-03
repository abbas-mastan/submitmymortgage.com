<?php

use App\Http\Controllers\AssociateController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'controller' => AssociateController::class,
        'prefix' => getAssociateRoutePrefix(),
        'middleware' => ['auth', 'associate'],
    ],
    function () {
        #associate profile
        Route::view('/profile', 'admin.profile.profile');
        Route::post('/do-profile', 'doProfile');
        #associate adding user
        Route::get('/all-users/{userId?}', 'allUsers');
        Route::get('/add-user/{userId}', 'addUser');
        Route::post('/do-user/{userId}', 'doUser');

        Route::get('/basic-info', 'basicInfo');
        Route::post('/do-info', 'doInfo');
        Route::get('/file-cat/{id}', 'filesCat');
        Route::get('/docs/{id}/{cat}', 'docs');

        Route::get('/delete-user/{userId}', 'deleteUser');
        Route::post('/file-upload', 'fileUpload');
        Route::post('/update-category-status', 'updateCategoryStatus');
        Route::get('/delete-file/{id}', 'deleteFile');
        Route::get('/disconnect-google', 'disconnectGoogle')->name('disconnect.google');
        Route::get('/hide-cat/{user}/{cat}', 'hideCategory')->where('cat', '(.*)');
        Route::get('/application/{id?}', 'application');
        Route::post('/do-application', 'doApplication');
        Route::get('/application-show/{application}', 'applicationShow');
        Route::get('/applications', 'applications');
        Route::get('/application-edit/{application}', 'applicationEdit');
        Route::post('/application-update/{application}', 'applicationUpdate');
        Route::get('/application-update-status/{application}/{status?}', 'applicationUpdateStatus');
        Route::get('/application-delete/{application}', 'deleteApplication');

        Route::get('/leads', 'allLeads');
        Route::get('/lead/{user}', 'lead');
        Route::get('/delete-lead/{info}', 'deleteLead');

        Route::post('/add-category/{user?}', 'addCategoryToUser');
        Route::post('/delete-category/{user?}/{cat}', 'deleteCategory');
        Route::get('/upload-files', 'uploadFilesView');
        Route::post('/upload-files', 'uploadFiles');
        Route::post('/spreadsheet', 'spreadsheet');
        Route::post('/export-contacts', 'exportContactsToExcel');

        //=============================================
        //=============> new Design Routes
        //=============================================
        Route::get('projects', 'projects');
        Route::post('store-project', 'storeProject');
        Route::get('/getUsersByTeam/{id}', 'getUsersByTeam');
        Route::get('/getUsersByProcessor/{id}/{teamid}', 'getUsersByProcessor');
        Route::get('teams', 'teams');
        Route::post('teams/{id?}', 'storeteam');
        Route::get('new-users', 'newusers');
        Route::get('contacts', 'contacts');
        Route::get('delete-contact/{contact}', 'deleteContact');
        Route::post('/do-contact/{id?}', 'doContact');
        Route::get('project-overview/{id?}', 'projectOverview');
        Route::get('/mark-as-read/{id}','markAsRead');
        Route::get('/redirect/{route}/{message}','redirectTo');


    }
);
