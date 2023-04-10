<?php

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GmailController;
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
  Route::get('/add-user/{userId}', [AdminController::class, 'addUser']);
  Route::post('/do-user/{userId}', [AdminController::class, 'doUser']);
  Route::get('/delete-user/{userId}', [AdminController::class, 'deleteUser']);
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
  //==============================
  //==========Profile related routes
  //==============================
  Route::get('/profile', [AdminController::class, 'profile']);
  Route::post('/do-profile', [AdminController::class, 'doProfile']);
});
Route::prefix(getAdminRoutePrefix())->group(function () {
  //==============================
  //==========Ajax routes
  //==============================
  //College related stuff
  Route::get('/get-colleges', [AdminController::class, 'getColleges']);
});
