<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\RoleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->controller(RoleController::class)->group(function(){
     Route::get('/roles','index')->name('roles.index');
     Route::post('/roles','store')->name('roles.store');
     Route::get('/roles/{role}','show')->name('roles.show')->whereNumber('role');
     Route::put('/roles/{role}','show')->name('roles.update')->whereNumber('role');
     Route::delete('/roles/{role}','delete')->name('roles.delete')->whereNumber('role');
     Route::delete('/roles/trash/{role}','trash')->name('roles.trash')->whereNumber('role');
});