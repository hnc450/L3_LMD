<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlainteController;
use App\Models\Service;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use Illuminate\Http\Request;
// Page d'accueil
Route::get('/', function () {
    return view('index');
})->name('index');

// Administration de la plateforme
Route::prefix('admin')->group(function () {
     Route::get('/', [AdminController::class, 'index'])->name('admin.index');

     Route::get('/roles',[RoleController::class, 'index'])->name('roles.index');
     Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
     Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
     Route::get('/roles/{id}',[RoleController::class, 'show'])->name('roles.show')->whereNumber('id');
     Route::delete('/roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.destroy')->whereNumber('id');
     Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
     Route::put('/roles/{id}/update', [RoleController::class, 'update'])->name('roles.update');

     Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
     Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
     Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('users.edit');
     Route::delete('/users/{user}/delete', [AdminController::class, 'destroyUser'])->name('users.destroy');
     Route::post('/users/store', [AdminController::class, 'store'])->name('users.store');
     Route::put('/users/{id}/update', [AdminController::class, 'updateUser'])->name('users.update');
     Route::get('/users/{id}/show', [AdminController::class, 'show'])->name('users.show')->whereNumber('id');

     Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
     Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');  
});

// Authentification
Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.sign');

Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'sign'])->name('auth.signup');

Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Plaintes
Route::get('/complaints/create', [PlainteController::class, 'create'])->name('complaints.create');
Route::get('/complaints/{id}', [PlainteController::class, 'show'])->name('complaint.show');
Route::get('/complaints/{id}/users/{user}', [PlainteController::class, 'showUser'])->name('complaint.show.user');
Route::post('/complaints/store', [PlainteController::class, 'store'])->name('complaints.store');
Route::get('/complaints', [PlainteController::class, 'index'])->name('complaints.index');
Route::get('/complaints/{id}/edit', [PlainteController::class, 'edit'])->name('complaint.edit');
Route::get('/complaints/{id}/responses', [PlainteController::class, 'responses'])->name('complaint.responses');


// Tableau de bord citoyen
Route::prefix('users')->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('dashboard');

    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile/{id}/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    // penser  à  un controller pour le profile et les settings pour séparer les responsabilités
    Route::get('/settings', [UserController::class, 'settings'])->name('user.settings');
 
    Route::put('/settings/email', [UserController::class, 'updateEmail'])->name('user.settings.email');
    Route::put('/settings/password', [UserController::class, 'updatePassword'])->name('user.settings.password');
});

// Interface agent
Route::prefix('agents')->group(function(){

    Route::get('/', [AgentController::class, 'index'])->name('agent.index');
    Route::get('/show/{id}/complaints', [AgentController::class, 'show'])->name('agent.show.complaints');
    Route::post('', [AgentController::class, 'respond'])->name('agent.respond');

});

// Notifications
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

// Feedback
Route::get('/feedback/{complaint_id}', [FeedbackController::class, 'create'])->name('feedback.create');

// Statistiques
Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

// Logs et traçabilité
Route::get('/logs', function () {
    return view('logs.index');
})->name('logs.index');


Route::get('/feedback/store', function () {
    return view('feedback.store');
})->name('feedback.store');

Route::get('reset/password', [AuthController::class, 'showResetForm'])->name('password.request');


// Gestion des services (CRUD via closures)
Route::get('/services', [ServiceController::class, 'services'])->name('services');


Route::post('/services/store', [ServiceController::class, 'store'])->name('services.store');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show')->whereNumber('id');
Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit')->whereNumber('id');
Route::put('/services/{id}/update',[ServiceController::class, 'update'])->name('services.update')->whereNumber('id');
Route::delete('/services/{id}/delete',[ServiceController::class, 'destroy'])->name('services.destroy')->whereNumber('id');