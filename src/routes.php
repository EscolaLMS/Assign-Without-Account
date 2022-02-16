<?php

use EscolaLms\AssignWithoutAccount\Http\Controllers\AccessUrlAdminController;
use EscolaLms\AssignWithoutAccount\Http\Controllers\UserSubmissionController;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/admin/access-url', 'middleware' => ['auth:api']], function () {
    Route::get('/', [AccessUrlAdminController::class, 'index']);
    Route::post('/', [AccessUrlAdminController::class, 'create']);
    Route::delete('/{id}', [AccessUrlAdminController::class, 'delete']);
    Route::patch('/{id}', [AccessUrlAdminController::class, 'update']);
});

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => '/user-submissions', 'middleware' => [SubstituteBindings::class]], function () {
        Route::post('/{accessUrl}', [UserSubmissionController::class, 'create']);
    });
    Route::group(['prefix' => 'admin/user-submissions', 'middleware' => ['auth:api']], function () {
        Route::get('/', [UserSubmissionController::class, 'index']);
        Route::get('/reject/{id}', [UserSubmissionController::class, 'reject']); // TODO
        Route::get('/accept/{id}', [UserSubmissionController::class, 'accept']); // TODO
    });
});

