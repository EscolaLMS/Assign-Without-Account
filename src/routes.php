<?php

use EscolaLms\AssignWithoutAccount\Http\Controllers\UserSubmissionAdminController;
use EscolaLms\Core\Http\Facades\Route;

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'admin/user-submissions', 'middleware' => Route::apply(['auth:api'])], function () {
        Route::get('/', [UserSubmissionAdminController::class, 'index']);
        Route::post('/', [UserSubmissionAdminController::class, 'create']);
        Route::put('/{id}', [UserSubmissionAdminController::class, 'update']);
        Route::delete('/{id}', [UserSubmissionAdminController::class, 'delete']);
    });
});

