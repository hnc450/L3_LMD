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
     Route::delete('/users/{id}/delete', [AdminController::class, 'destroy'])->name('users.destroy');
     Route::post('/users/store', [AdminController::class, 'store'])->name('users.store');
     Route::put('/users/{id}/update', [AdminController::class, 'update'])->name('users.update');
     Route::get('/users/{id}/show', [AdminController::class, 'show'])->name('users.show')->whereNumber('id');
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
});

// Interface agent
Route::get('/agent', [AgentController::class, 'index'])->name('agent.index');

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

Route::get('/service', [ServiceController::class, 'services'])->name('services');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');


Route::post('/services/store', function (Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $service = new Service();
    $service->name = $data['name'];
    $service->description = $data['description'] ?? null;
    $service->save();

    return redirect()->route('services.index');
})->name('services.store');

Route::get('/services/{id}', function ($id) {
    $service = Service::findOrFail($id);
    return view('services.show', ['service' => $service]);
})->name('services.show')->whereNumber('id');

Route::get('/services/{id}/edit', function ($id) {
    $service = Service::findOrFail($id);
    return view('services.edit', ['service' => $service]);
})->name('services.edit')->whereNumber('id');

Route::put('/services/{id}/update', function (Request $request, $id) {
    $service = Service::findOrFail($id);
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);
    $service->name = $data['name'];
    $service->description = $data['description'] ?? null;
    $service->save();
    return redirect()->route('services.index');
})->name('services.update');

Route::delete('/services/{id}/delete', function ($id) {
    $service = Service::findOrFail($id);
    $service->delete();
    return redirect()->route('services.index');
})->name('services.destroy');