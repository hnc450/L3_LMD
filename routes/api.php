<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\NotificationApiController;
use App\Http\Controllers\Api\PlainteApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\StatistiqueApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthApiController::class, 'login']);

    Route::middleware('api.token')->group(function () {
        Route::post('/auth/logout', [AuthApiController::class, 'logout']);
        Route::get('/auth/me', [AuthApiController::class, 'me']);

        Route::get('/services', [ServiceApiController::class, 'index']);
        Route::get('/services/{service}', [ServiceApiController::class, 'show'])->whereNumber('service');

        Route::get('/plaintes', [PlainteApiController::class, 'index']);
        Route::post('/plaintes', [PlainteApiController::class, 'store']);
        Route::get('/plaintes/{plainte}', [PlainteApiController::class, 'show'])->whereNumber('plainte');
        Route::get('/plaintes/track/{code}', [PlainteApiController::class, 'track']);

        Route::get('/notifications', [NotificationApiController::class, 'index']);
        Route::patch('/notifications/{notification}/read', [NotificationApiController::class, 'markRead'])->whereNumber('notification');

        Route::middleware('role:admin,responsable')->group(function () {
            Route::get('/statistics', [StatistiqueApiController::class, 'index']);
        });
    });
});
