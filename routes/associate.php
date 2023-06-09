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
    Route::get('/add-user/{userId}', 'addUser');
    Route::post('/do-user/{userId}', 'doUser');

    Route::get('/basic-info', 'basicInfo');
    Route::get('/application', 'application');
    Route::get('/file-cat/{id}', 'filesCat');

    Route::get('/docs/{id}/{cat}', 'docs');
    Route::get('/application-show/{application}', 'applicationShow');

    Route::get('/all-users', 'allUsers');
    Route::post('/do-application', 'doApplication');
    Route::get('/delete-user/{userId}', 'deleteUser');
    Route::post('/file-upload', 'fileUpload');
    Route::post('/update-category-status', 'updateCategoryStatus');
    Route::get('/delete-file/{id}','deleteFile');

  }
);
