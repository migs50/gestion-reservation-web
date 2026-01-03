<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ResourceManagementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Responsable\ResponsableDashboardController;
use App\Http\Controllers\Responsable\ResponsableResourceController;
use App\Http\Controllers\Responsable\ResponsableRequestController;




//Routes PUBLIQUES (Invité)//
Route::get('/', [PublicController::class, 'home'])->name('public.home');

Route::get('/ressources', [PublicController::class, 'resources'])->name('public.resources');
Route::get('/ressources/{id}', [PublicController::class, 'resourceDetails'])->name('public.resource.details');

Route::get('/rules', [PublicController::class, 'rules'])->name('public.rules');

Route::get('/request-account', [PublicController::class, 'requestAccount'])->name('public.request.account');
Route::post('/request-account', [PublicController::class, 'storeAccountRequest'])->name('public.request.account.store');



//Routes AUTH (Authentification)//



Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

//Routes UTILISATEURS (User)//


Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');

    Route::get('/history', [UserController::class, 'history'])->name('history');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

    Route::get('/incident', [UserController::class, 'incidentForm'])->name('incident.form');
    Route::post('/incident', [UserController::class, 'storeIncident'])->name('incident.store');
});


//Routes ADMIN (Administrateur)//

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gestion utilisateurs
    Route::get('/users', [UserManagementController::class, 'index'])->name('users');
    Route::put('/users/{id}/toggle', [UserManagementController::class, 'toggleStatus'])->name('users.toggle');

    // Gestion ressources
    Route::get('/ressources', [ResourceManagementController::class, 'index'])->name('resources');
    Route::post('/ressources', [ResourceManagementController::class, 'store'])->name('resources.store');
    Route::put('/ressources/{id}', [ResourceManagementController::class, 'update'])->name('resources.update');

    // Catégories
    Route::resource('/categories', CategoryController::class);

    // Statistiques
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');

    // Maintenance
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance');
    Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');
});


//Routes RESPONSABLE (Responsable de ressources)//


Route::middleware(['auth', 'role:responsable'])->prefix('responsable')->name('responsable.')->group(function () {

    Route::get('/dashboard', [ResponsableDashboardController::class, 'index'])->name('dashboard');

    Route::get('/ressources', [ResponsableResourceController::class, 'index'])->name('resources');
    Route::put('/ressources/{id}/status', [ResponsableResourceController::class, 'updateStatus'])->name('resources.status');

    Route::get('/requests', [ResponsableRequestController::class, 'index'])->name('requests');
    Route::get('/requests/{id}', [ResponsableRequestController::class, 'show'])->name('requests.show');
    Route::post('/requests/{id}/approve', [ResponsableRequestController::class, 'approve'])->name('requests.approve');
    Route::post('/requests/{id}/reject', [ResponsableRequestController::class, 'reject'])->name('requests.reject');
});



