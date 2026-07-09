<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlainteController;
// Page d'accueil
Route::get('/', function () {
    return view('index');
})->name('index');

// Authentification
Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'sign'])->name('auth.register.post');

// Plaintes
Route::get('/complaints/create', [PlainteController::class, 'create'])->name('complaints.create');
Route::get('/complaints/{id}', [PlainteController::class, 'show'])->name('complaint.show');


Route::get('/complaints/{id}/users/{user}', function ($id, $user) {

})->name('complaint.show.user');

Route::post('/complaints/store', function () {
    
})->name('complaints.store');


Route::get('/complaints', [PlainteController::class, 'index'])->name('complaints.index');


Route::get('/complaints/{id}/edit', function ($id) {
    return view('complaints.edit', ['id' => $id]);
})->name('complaint.edit');

Route::get('/complaints/{id}/responses', function ($id) {
    return view('complaints.responses', ['id' => $id]);
})->name('complaint.responses');

// Tableau de bord citoyen

Route::get('/dashboard', function () {
    return view('users.index');
})->name('dashboard');

// Interface administrateur
Route::get('/admin', function () {
    return view('admins.index');
})->name('admin.index');

// Interface agent
Route::get('/agent', function () {
    return view('agents.index');
})->name('agent.index');

// Notifications
Route::get('/notifications', function () {
    return view('notifications.index');
})->name('notifications.index');

// Feedback
Route::get('/feedback/{complaint_id}', function ($complaint_id) {
    return view('feedback.create', ['complaint_id' => $complaint_id]);
})->name('feedback.create');

// Statistiques
Route::get('/statistics', function () {
    return view('statistics.index');
})->name('statistics.index');

// Logs et traçabilité
Route::get('/logs', function () {
    return view('logs.index');
})->name('logs.index');


Route::get('/feedback/store', function () {
    return view('feedback.store');
})->name('feedback.store');

Route::get('reset/password', [AuthController::class, 'showResetForm'])->name('password.request');

// Gestion des rôles
Route::get('/roles',[RoleController::class, 'index'])->name('roles.index');
Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
Route::get('/roles/{id}',[RoleController::class, 'show'])->name('roles.show')->whereNumber('id');
Route::delete('/roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.destroy')->whereNumber('id');
Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
Route::put('/roles/{id}/update', [RoleController::class, 'update'])->name('roles.update');