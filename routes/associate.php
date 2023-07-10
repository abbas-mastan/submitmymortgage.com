<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssociateController;




Route::group(
  [
    'controller' => AssociateController::class,
    'prefix' => getAssociateRoutePrefix(),
    'middleware' => ['auth', 'associate']
  ],
  function () {
    #associate profile
    Route::get('/profile', 'profile');
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
    Route::get('/disconnect-google',  'disconnectGoogle')->name('disconnect.google');

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
  }
);
