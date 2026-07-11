<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlainteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\StatistiqueController;

// Page d'accueil

Route::prefix('/')->group(function(){
   Route::get('', [HomeController::class,'index'])->name('index');
   Route::get('/services', [HomeController::class, 'services'])->name('services');
});

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
     Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
     Route::put('/users/{id}/update', [AdminController::class, 'updateUser'])->name('users.update');
     Route::get('/users/{id}/show', [AdminController::class, 'show'])->name('users.show')->whereNumber('id');

     Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
     Route::post('/services/store', [ServiceController::class, 'store'])->name('services.store');
     Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');  
     Route::get('/services/{id}/show', [ServiceController::class, 'show'])->name('services.show')->whereNumber('id');
     Route::delete('/services/{id}/delete',[ServiceController::class, 'destroy'])->name('services.destroy')->whereNumber('id');
     Route::get('/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit')->whereNumber('id');
     Route::put('/services/{id}/update',[ServiceController::class, 'update'])->name('services.update')->whereNumber('id');
});

// Authentification
Route::prefix('auth')->name('auth.')->group(function(){
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('sign');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'sign'])->name('signup');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

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

// Interface responsable

Route::prefix('responsables')->name('responsable.')->group(function(){
  Route::get('/',[ResponsableController::class,'index'])->name('index');
  Route::get('/agents',[ResponsableController::class,'agents'])->name('agents');
  Route::get('/agents/create',[])->name('agents.create');
});

// Notifications
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

// Feedback
Route::get('/feedback/{complaint_id}', [FeedbackController::class, 'create'])->name('feedback.create');

// Statistiques
Route::get('/statistics', [StatistiqueController::class, 'index'])->name('statistics.index');

// Logs et traçabilité
Route::get('/logs', function () {
    return view('logs.index');
})->name('logs.index');

Route::get('/feedback/store', function () {
    return view('feedback.store');
})->name('feedback.store');

Route::get('reset/password', [AuthController::class, 'showResetForm'])->name('password.request');