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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\RessourceController as AdminRessourceController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;

/*
|--------------------------------------------------------------------------
| Notifications (user)
|--------------------------------------------------------------------------
*/

Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('user.notifications');

Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])
    ->name('user.notifications.markRead');

Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])
    ->name('user.notifications.markAllRead');

Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
    ->name('user.notifications.destroy');

/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/

Route::get('/', [GuestController::class, 'index'])->name('home');

Route::get('/catalogue', [GuestController::class, 'catalogue'])->name('catalogue');
Route::get('/regles', [GuestController::class, 'regles'])->name('regles');
Route::get('/rules', [GuestController::class, 'rules'])->name('rules');
Route::get('/contact', [GuestController::class, 'contact'])->name('contact');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/register/success', [RegisterController::class, 'success'])->name('register.success');

Route::get('/demande-compte', [DemandeCompteController::class, 'create'])->name('demande.compte');
Route::post('/demande-compte', [DemandeCompteController::class, 'store'])->name('demande.compte.store');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Public ressources (catalogue details)
|--------------------------------------------------------------------------
*/

Route::get('/ressources', [RessourceController::class, 'index'])->name('ressources.index');
Route::get('/ressources/{ressource}', [RessourceController::class, 'show'])->name('ressources.show');

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

    // User reservations (normal users)
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/ressources/{ressource}/reserver', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    /*
    |--------------------------------------------------------------------------
    | ADMIN routes (only Admin role, under /admin)
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:Admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Admin ressources
            Route::get('/ressources', [AdminRessourceController::class, 'index'])->name('ressources.index');
            Route::get('/ressources/create', [AdminRessourceController::class, 'create'])->name('ressources.create');
            Route::post('/ressources', [AdminRessourceController::class, 'store'])->name('ressources.store');

            // Admin reservations
            Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
            Route::get('/reservations/create', [AdminReservationController::class, 'create'])->name('reservations.create');
            Route::post('/reservations', [AdminReservationController::class, 'store'])->name('reservations.store');

            // Approve / refuse reservations
            Route::post('/reservations/{reservation}/approve', [AdminReservationController::class, 'approve'])
                ->name('reservations.approve');
            Route::post('/reservations/{reservation}/refuse', [AdminReservationController::class, 'refuse'])
                ->name('reservations.refuse');

            // Demandes de compte (admin validates new users)
            Route::get('/demandes', [DemandeCompteController::class, 'index'])->name('demandes.index');
            Route::post('/demandes/{demande}/accept', [DemandeCompteController::class, 'accept'])->name('demandes.accept');
            Route::post('/demandes/{demande}/reject', [DemandeCompteController::class, 'reject'])->name('demandes.reject');
        });
});
