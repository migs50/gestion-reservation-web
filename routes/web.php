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
use App\Http\Controllers\Admin\RessourceController as AdminRessourceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;



// Notifications list
Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('user.notifications');

// Mark ONE notification as read
Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])
    ->name('user.notifications.markRead');

// Mark ALL as read
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])
    ->name('user.notifications.markAllRead');

// Delete notification(if we ever adda delete button) 
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
    ->name('user.notifications.destroy');






/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/

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

// Registration
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/register/success', [RegisterController::class, 'success'])->name('register.success');

// Demande de création de compte
Route::get('/demande-compte', [DemandeCompteController::class, 'create'])->name('demande.compte');
Route::post('/demande-compte', [DemandeCompteController::class, 'store'])->name('demande.compte.store');

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
    // Ressources
    Route::get('/ressources', [RessourceController::class, 'index'])->name('ressources.index');
    Route::get('/ressources/{ressource}', [RessourceController::class, 'show'])->name('ressources.show');


Route::middleware('auth')->group(function () {


//===============================================================================================================


        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // ...other authenticated routes...

    Route::prefix('admin')->name('admin.')->group(function () {
        // Formulaire de création de ressource
        Route::get('/ressources/create', [AdminRessourceController::class, 'create'])
            ->name('ressources.create');
         // Enregistrement de la ressource
        Route::post('/ressources', [AdminRessourceController::class, 'store'])
            ->name('ressources.store');
        Route::get('/ressources', [AdminRessourceController::class, 'index'])
            ->name('ressources.index');


        // Reservations (ADMIN)
        Route::get('/reservations', [AdminReservationController::class, 'index'])
            ->name('reservations.index');
        Route::get('/reservations/create', [AdminReservationController::class, 'create'])
            ->name('reservations.create');
        Route::post('/reservations', [AdminReservationController::class, 'store'])
            ->name('reservations.store');
    });

    // User reservations (existing)
            Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
            Route::get('/ressources/{ressource}/reserver', [ReservationController::class, 'create'])->name('reservations.create');
            Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');


//==================================================================================================================


  // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/profile/reservations', [ProfileController::class, 'reservations'])->name('profile.reservations');


    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/ressources/{ressource}/reserver', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    // (Optional) admin / manager routes you actually implemented before
});
