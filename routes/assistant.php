<?php

use App\Http\Controllers\AssistantController;
use Illuminate\Support\Facades\Route;

Route::prefix(getAssistantRoutePrefix())->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('assitant-register', [AssistantController::class, 'assistantRegister'])->name('assistant.register');
    });
    Route::post('/register-assistant/{user}', [AssistantController::class, 'doAssistant']);
    Route::middleware(['auth', 'assistant'])->group(function () {
        Route::get('/submit-document', [AssistantController::class, 'submitDocumentView']);
        Route::post('/submit-document', [AssistantController::class, 'submitDocument']);
        Route::get('/delete-file/{id}', [AssistantController::class, 'deleteFile']);
    });
});
