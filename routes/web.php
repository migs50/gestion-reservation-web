<?php

use Illuminate\Support\Facades\Route;

// Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\PasswordSecretController;

// User Controllers
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\DemandeCompteController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\IncidentController;

// Admin Controllers
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\RessourceController as AdminRessourceController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategorieController as AdminCategorieController;
use App\Http\Controllers\Admin\MaintenanceController as AdminMaintenanceController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Responsable\ResponsableController;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/

Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/catalogue', [GuestController::class, 'catalogue'])->name('catalogue');
Route::get('/regles', [GuestController::class, 'regles'])->name('regles');
Route::get('/rules', [GuestController::class, 'rules'])->name('rules');

// Public ressources catalogue
Route::get('/ressources', [RessourceController::class, 'index'])->name('publique.ressources');
Route::get('/ressources/{ressource}', [RessourceController::class, 'show'])->name('ressources.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/inscription', [DemandeCompteController::class, 'create'])->name('inscription');
Route::get('/demande-compte', [DemandeCompteController::class, 'create'])->name('demande.compte');
Route::post('/demande-compte', [DemandeCompteController::class, 'store'])->name('demande.compte.store');

// Page de succès
Route::get('/demande-compte/success', function() {
    return view('auth.register_success');
})->name('register.success');
Route::get('/demande-compte', [DemandeCompteController::class, 'create'])->name('demande.compte');
Route::post('/demande-compte', [DemandeCompteController::class, 'store'])->name('demande.compte.store');

// Password Reset
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Secret question reset
Route::get('/forgot-password-secret', [PasswordSecretController::class, 'showEmailForm'])->name('secret.email');
Route::post('/forgot-password-secret', [PasswordSecretController::class, 'checkEmail']);
Route::get('/forgot-password-secret/question', [PasswordSecretController::class, 'showQuestionForm'])->name('secret.question');
Route::post('/forgot-password-secret/reset', [PasswordSecretController::class, 'resetPassword'])->name('secret.reset');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Users)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('dashboard.user');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/profile/reservations', [ProfileController::class, 'reservations'])->name('profile.reservations');

    // Notifications (User)
    Route::get('/notifications', [NotificationController::class, 'index'])->name('user.notifications');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('user.notifications.markRead');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('user.notifications.markAllRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('user.notifications.destroy');

    // Reservations (User)
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/ressources/{ressource}/reserver', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::post('/reservations/{reservation}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
    Route::post('/reservations/{reservation}/refuse', [ReservationController::class, 'refuse'])->name('reservations.refuse');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');

    // Incidents (User)
    Route::get('/incidents', [IncidentController::class, 'index'])->name('user.incidents.index');
    Route::get('/incidents/create', [IncidentController::class, 'create'])->name('user.incidents.create');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('user.incidents.store');
    Route::get('/incidents/{incident}', [IncidentController::class, 'show'])->name('user.incidents.show');

    /*
    |--------------------------------------------------------------------------
    | RESPONSABLE routes (Only Responsable Technique)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Responsable')
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
            
            Route::get('/reservations', [ReservationController::class, 'responsableIndex'])->name('reservations.index');
            Route::post('/reservations/{reservation}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
            Route::post('/reservations/{reservation}/refuse', [ReservationController::class, 'refuse'])->name('reservations.refuse');

            Route::get('/requests', [ResponsableController::class, 'indexRequests'])->name('requests');
            Route::get('/requests/{reservation}', [ResponsableController::class, 'showRequest'])->name('requests.show');
            Route::post('/requests/{reservation}/approve', [ResponsableController::class, 'approveRequest'])->name('requests.approve');
            Route::post('/requests/{reservation}/reject', [ResponsableController::class, 'rejectRequest'])->name('requests.reject');

            // Moderation
            Route::get('/discussions', [ResponsableController::class, 'discussions'])->name('discussions');
            Route::post('/messages/{message}/hide', [ResponsableController::class, 'hideMessage'])->name('messages.hide');
        });
});

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Statistics
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');

        // Admin Ressources
        Route::get('/ressources', [AdminRessourceController::class, 'index'])->name('ressources.index');
        Route::get('/ressources/create', [AdminRessourceController::class, 'create'])->name('ressources.create');
        Route::post('/ressources', [AdminRessourceController::class, 'store'])->name('ressources.store');
        Route::get('/ressources/{ressource}', [AdminRessourceController::class, 'show'])->name('ressources.show');
        Route::get('/ressources/{ressource}/edit', [AdminRessourceController::class, 'edit'])->name('ressources.edit');
        Route::put('/ressources/{ressource}', [AdminRessourceController::class, 'update'])->name('ressources.update');
        Route::patch('/ressources/{ressource}/toggle-actif', [AdminRessourceController::class, 'toggleActif'])->name('ressources.toggleActif');
        Route::delete('/ressources/{ressource}', [AdminRessourceController::class, 'destroy'])->name('ressources.destroy');

        // Admin Reservations
        Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/create', [AdminReservationController::class, 'create'])->name('reservations.create');
        Route::post('/reservations', [AdminReservationController::class, 'store'])->name('reservations.store');
        Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');
        Route::post('/reservations/{reservation}/approve', [AdminReservationController::class, 'approve'])->name('reservations.approve');
        Route::post('/reservations/{reservation}/refuse', [AdminReservationController::class, 'refuse'])->name('reservations.refuse');

        // Admin Users
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Admin Categories
        Route::get('/categories', [AdminCategorieController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [AdminCategorieController::class, 'create'])->name('categories.create');
        Route::post('/categories', [AdminCategorieController::class, 'store'])->name('categories.store');
        Route::get('/categories/{categorie}', [AdminCategorieController::class, 'show'])->name('categories.show');
        Route::get('/categories/{categorie}/edit', [AdminCategorieController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{categorie}', [AdminCategorieController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{categorie}', [AdminCategorieController::class, 'destroy'])->name('categories.destroy');

        // Admin Maintenance
        Route::get('/maintenances', [AdminMaintenanceController::class, 'index'])->name('maintenances.index');
        Route::get('/maintenances/create', [AdminMaintenanceController::class, 'create'])->name('maintenances.create');
        Route::post('/maintenances', [AdminMaintenanceController::class, 'store'])->name('maintenances.store');
        Route::get('/maintenances/{maintenance}', [AdminMaintenanceController::class, 'show'])->name('maintenances.show');
        Route::get('/maintenances/{maintenance}/edit', [AdminMaintenanceController::class, 'edit'])->name('maintenances.edit');
        Route::put('/maintenances/{maintenance}', [AdminMaintenanceController::class, 'update'])->name('maintenances.update');
        Route::delete('/maintenances/{maintenance}', [AdminMaintenanceController::class, 'destroy'])->name('maintenances.destroy');

        // Admin Roles
        Route::get('/roles', [AdminRoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [AdminRoleController::class, 'create'])->name('roles.create');
        Route::post('/roles', [AdminRoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}', [AdminRoleController::class, 'show'])->name('roles.show');
        Route::get('/roles/{role}/edit', [AdminRoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{role}', [AdminRoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [AdminRoleController::class, 'destroy'])->name('roles.destroy');

        // Demandes compte
        Route::get('/demandes', [DemandeCompteController::class, 'index'])->name('demandes.index');
        Route::post('/demandes/{demande}/accept', [DemandeCompteController::class, 'accept'])->name('demandes.accept');
        Route::post('/demandes/{demande}/reject', [DemandeCompteController::class, 'reject'])->name('demandes.reject');
    });