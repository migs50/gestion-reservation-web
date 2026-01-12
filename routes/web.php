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
use App\Http\Controllers\Admin\StatisticsController as AdminStatisticsController;
use App\Http\Controllers\Admin\RessourceController as AdminRessourceController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategorieController as AdminCategorieController;
use App\Http\Controllers\Admin\MaintenanceController as AdminMaintenanceController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Responsable\ResponsableController;

/*
|--------------------------------------------------------------------------
| Notifications (user)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('user.notifications');

Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])
    ->name('user.notifications.markRead');

Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])
    ->name('user.notifications.markAllRead');

Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])
    ->name('user.notifications.destroy');
});
/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/


Route::get('/', [GuestController::class, 'index'])->name('home');

Route::get('/catalogue', [GuestController::class, 'catalogue'])->name('catalogue');
Route::get('/ressources', [RessourceController::class, 'index'])->name('publique.ressources');
Route::get('/ressources/{ressource}', [RessourceController::class, 'show'])->name('ressources.show');
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

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/



Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/user', [DashboardController::class, 'user']) ->name('dashboard.user');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/profile/reservations', [ProfileController::class, 'reservations'])->name('profile.reservations');

    // User reservations (normal users)
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/ressources/{ressource}/reserver', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/create', [ReservationController::class, 'create']) ->name('reservations.create');
    Route::post('/reservations/{reservation}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('/reservations/{reservation}/refuse', [ReservationController::class, 'refuse'])->name('reservations.refuse');
    Route::delete('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    
    // User Incidents (Reporting)
    Route::get('/incidents', [App\Http\Controllers\IncidentController::class, 'index'])->name('user.incidents.index');
    Route::get('/incidents/create', [App\Http\Controllers\IncidentController::class, 'create'])->name('user.incidents.create');
    Route::post('/incidents', [App\Http\Controllers\IncidentController::class, 'store'])->name('user.incidents.store');
    Route::get('/incidents/{incident}', [App\Http\Controllers\IncidentController::class, 'show'])->name('user.incidents.show');
    
    /*
    |--------------------------------------------------------------------------
    | ADMIN routes (only Admin role, under /admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // Admin dashboard statistics
            Route::get('/statistics', [AdminStatisticsController::class, 'index'])->name('statistics');

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

            // Admin users management
            Route::get('/users', [AdminUserController::class, 'index'])->name('users');
            Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
            Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
            Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');

            // Admin categories management
            Route::resource('categories', AdminCategorieController::class);

            // Admin maintenance management
            Route::resource('maintenance', AdminMaintenanceController::class);

            // Admin roles & permissions
            Route::resource('roles', AdminRoleController::class);

            // Admin ressources management
            Route::resource('ressources', AdminRessourceController::class);
            Route::patch('ressources/{ressource}/toggle-actif', [AdminRessourceController::class, 'toggleActif'])
                ->name('ressources.toggleActif');
        });

    /*
    |--------------------------------------------------------------------------
    | RESPONSABLE routes (Only Responsable Technique)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Responsable Technique')
        ->prefix('responsable')
        ->name('responsable.')
        ->group(function () {
            Route::get('/ressources', [ResponsableController::class, 'indexRessources'])->name('ressources');
            Route::get('/ressources/create', [ResponsableController::class, 'createRessource'])->name('ressources.create');
            Route::post('/ressources', [ResponsableController::class, 'storeRessource'])->name('ressources.store');
            Route::get('/ressources/{resource}/edit', [ResponsableController::class, 'editRessource'])->name('ressources.edit');
            Route::put('/ressources/{resource}', [ResponsableController::class, 'updateRessource'])->name('ressources.update');
            Route::post('/resources/{resource}/maintenance', [ResponsableController::class, 'maintenance'])->name('resources.maintenance');
            Route::post('/resources/{resource}/enable', [ResponsableController::class, 'enable'])->name('resources.enable');
            Route::post('/resources/{resource}/disable', [ResponsableController::class, 'disable'])->name('resources.disable');

            Route::get('/requests', [ResponsableController::class, 'indexRequests'])->name('requests');
            Route::get('/requests/{reservation}', [ResponsableController::class, 'showRequest'])->name('requests.show');
            Route::post('/requests/{reservation}/approve', [ResponsableController::class, 'approveRequest'])->name('requests.approve');
            Route::post('/requests/{reservation}/reject', [ResponsableController::class, 'rejectRequest'])->name('requests.reject');

            // Moderation
            Route::get('/discussions', [ResponsableController::class, 'discussions'])->name('discussions');
            Route::post('/messages/{message}/hide', [ResponsableController::class, 'hideMessage'])->name('messages.hide');
        });
});



