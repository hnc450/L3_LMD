<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PlainteController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::name('public.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/services', [HomeController::class, 'services'])->name('services');
    Route::get('/suivi', [PlainteController::class, 'trackForm'])->name('track.form');
    Route::post('/suivi', [PlainteController::class, 'track'])->name('track');
});

Route::prefix('auth')->name('auth.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'index'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('sign');
        Route::get('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/register', [AuthController::class, 'sign'])->name('signup');
        Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.request');
        Route::post('/reset-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    });
    Route::middleware('auth')->delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('complaints')->name('complaints.')->group(function () {
    Route::get('/create', [PlainteController::class, 'create'])->name('create');
    Route::post('/store', [PlainteController::class, 'store'])->name('store');
    Route::get('/{plainte}', [PlainteController::class, 'show'])->name('show')->whereNumber('plainte');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/', [PlainteController::class, 'index'])->name('index');
        Route::get('/{plainte}/edit', [PlainteController::class, 'edit'])->name('edit')->whereNumber('plainte');
        Route::put('/{plainte}/update', [PlainteController::class, 'update'])->name('update')->whereNumber('plainte');
    });

    Route::middleware(['auth', 'role:responsable'])->group(function () {
        Route::delete('/{plainte}/delete', [PlainteController::class, 'destroy'])->name('destroy')->whereNumber('plainte');
    });
});

Route::prefix('users')->middleware(['auth', 'role:citoyen'])->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [UserController::class, 'settings'])->name('settings');
    Route::put('/settings/email', [UserController::class, 'updateEmail'])->name('settings.email');
    Route::put('/settings/password', [UserController::class, 'updatePassword'])->name('settings.password');
    Route::get('/logs', [LogController::class, 'index'])->name('logs');
});

Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
    Route::get('/users/{user}/show', [AdminController::class, 'show'])->name('users.show')->whereNumber('user');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit')->whereNumber('user');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}/update', [AdminController::class, 'updateUser'])->name('users.update')->whereNumber('user');
    Route::delete('/users/{user}/delete', [AdminController::class, 'destroyUser'])->name('users.destroy')->whereNumber('user');
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show')->whereNumber('role');
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services/store', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/show', [ServiceController::class, 'show'])->name('services.show')->whereNumber('service');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit')->whereNumber('service');
    Route::put('/services/{service}/update', [ServiceController::class, 'update'])->name('services.update')->whereNumber('service');
    Route::delete('/services/{service}/delete', [ServiceController::class, 'destroy'])->name('services.destroy')->whereNumber('service');
    Route::get('/statistics', [StatistiqueController::class, 'index'])->name('statistics');
    Route::get('/logs', [LogController::class, 'index'])->name('logs');
});

Route::prefix('agents')->middleware(['auth', 'role:agent'])->name('agent.')->group(function () {
    Route::get('/', [AgentController::class, 'index'])->name('index');
    Route::post('/respond', [AgentController::class, 'respond'])->name('respond');
    Route::get('/logs', [LogController::class, 'index'])->name('logs');
});

Route::prefix('responsables')->middleware(['auth', 'role:responsable'])->name('responsable.')->group(function () {
    Route::get('/', [ResponsableController::class, 'index'])->name('index');
    Route::post('/complaints/assign', [ResponsableController::class, 'assign'])->name('assign');
    Route::post('/complaints/status', [ResponsableController::class, 'updateStatus'])->name('update-status');
    Route::get('/agents', [ResponsableController::class, 'agents'])->name('agents');
    Route::get('/agents/create', [ResponsableController::class, 'createAgent'])->name('agents.create');
    Route::post('/agents/store', [ResponsableController::class, 'storeAgent'])->name('agents.store');
    Route::get('/statistics', [StatistiqueController::class, 'index'])->name('statistics');
    Route::get('/logs', [LogController::class, 'index'])->name('logs');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-read');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read')->whereNumber('notification');
    Route::get('/feedback/{plainte}', [FeedbackController::class, 'create'])->name('feedback.create')->whereNumber('plainte');
    Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');
});

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/dashboard', fn () => redirect()->route(auth()->user()?->dashboardRoute() ?? 'auth.login'))->middleware('auth')->name('dashboard');
Route::get('/statistics', fn () => redirect()->route(auth()->user()?->isResponsable() ? 'responsable.statistics' : 'admin.statistics'))->middleware('auth')->name('statistics.index');
Route::get('/logs', function () {
    $user = auth()->user();
    if (! $user) {
        return redirect()->route('auth.login');
    }

    return redirect()->route(match ($user->role?->name) {
        'admin' => 'admin.logs',
        'agent' => 'agent.logs',
        'responsable' => 'responsable.logs',
        'citoyen' => 'user.logs',
        default => 'auth.login',
    });
})->middleware('auth')->name('logs.index');
