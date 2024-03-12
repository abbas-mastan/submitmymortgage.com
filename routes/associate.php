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
        require __DIR__ . '/common.php';
    }
);
