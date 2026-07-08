<?php

use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    return view('index');
})->name('index');

// Authentification
Route::get('/login', function () {
    return view('auth.login');
})->name('auth.login');

Route::get('/register', function () {
    return view('auth.register');
})->name('auth.register');

// Plaintes
Route::get('/complaints/create', function () {
    return view('complaints.create');
})->name('complaints.create');

Route::get('/complaints/{id}', function ($id) {
    return view('complaints.show', ['id' => $id]);
})->name('complaint.show');


Route::post('/complaints/store', function () {
    
})->name('complaints.store');


Route::get('/complaints', function () {
    return view('complaints.index');
})->name('complaints.index');


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

Route::get('reset/password', function () {
    
})->name('password.request');
