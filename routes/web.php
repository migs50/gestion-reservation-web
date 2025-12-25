<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\DemandeCompteController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/catalogue', function () {
    return view('catalogue');
})->name('catalogue');

Route::get('/regles', function () {
    return view('regles');
})->name('regles');

Route::get('/demande-compte', function () {
    return view('demande-compte');
})->name('demande-compte');


// Home page
Route::get('/', [GuestController::class, 'index'])->name('home');

// Guest pages
Route::get('/catalogue', [GuestController::class, 'catalogue'])->name('catalogue');
Route::get('/regles', [GuestController::class, 'regles'])->name('regles');
Route::get('/rules', [GuestController::class, 'rules'])->name('rules');
Route::get('/contact', [GuestController::class, 'contact'])->name('contact');


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration (Account Request)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/demande-compte', [RegisterController::class, 'showRegistrationForm'])->name('demande.compte');
Route::post('/demande-compte', [RegisterController::class, 'register'])->name('demande.compte.store');

// Password Reset
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/profile/reservations', [ProfileController::class, 'reservations'])->name('profile.reservations');

    // Resources
    Route::get('/ressources', [RessourceController::class, 'index'])->name('ressources.index');
    Route::get('/ressources/{ressource}', [RessourceController::class, 'show'])->name('ressources.show');

    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.list');
    Route::get('/ressources/{ressource}/reserver', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    /*
    |--------------------------------------------------------------------------
    | Admin & Manager Routes
    |--------------------------------------------------------------------------
    */

    // Admin only routes
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', function () { return view('admin.users'); })->name('users');
        Route::get('/roles', function () { return view('admin.roles'); })->name('roles');
        Route::get('/demandes', function () { return view('admin.demandes'); })->name('demandes');
        Route::get('/statistics', function () { return view('admin.statistics'); })->name('statistics');
    });

    // Responsable routes
    Route::middleware(['role:Admin,Responsable'])->prefix('manager')->name('manager.')->group(function () {
        Route::get('/ressources', function () { return view('manager.ressources'); })->name('ressources');
        Route::get('/requests', function () { return view('manager.requests'); })->name('requests');
    });
});
