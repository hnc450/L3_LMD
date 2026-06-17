<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;

Route::get('/users', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('categories',CategoryController::class);
Route::apiResource('roles',RoleController::class);