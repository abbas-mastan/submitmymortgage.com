<?php

use App\Http\Controllers\AssistantController;
use Illuminate\Support\Facades\Route;

Route::prefix(getAssistantRoutePrefix())->group(function () {
    Route::post('/register-assistant/{user}', [AssistantController::class, 'doAssistant']);
    Route::middleware(['auth', 'assistant'])->group(function () {
        Route::get('/submit-document', [AssistantController::class, 'submitDocument']);
        Route::get('/logout', [AssistantController::class, 'logout']);
        });
    Route::get('/login', [AssistantController::class, 'login']);
});
