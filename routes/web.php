<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\GuestController;
// use App\Http\Controllers\DemandeCompteController;

// /*
// |--------------------------------------------------------------------------
// | Routes publiques (Invité)
// |--------------------------------------------------------------------------
// */

// // Page d'accueil
// Route::get('/', [GuestController::class, 'index'])->name('home');

// // Catalogue des ressources
// Route::get('/catalogue', [GuestController::class, 'catalogue'])->name('catalogue');

// // Règles d'utilisation
// Route::get('/regles', [GuestController::class, 'regles'])->name('regles');

// // Demande de compte
// Route::get('/demande-compte', [DemandeCompteController::class, 'create'])->name('demande.compte');
// Route::post('/demande-compte', [DemandeCompteController::class, 'store'])->name('demande.compte.store');



// //routing for reservations/resources
// use App\Http\Controllers\RessourceController;
// use App\Http\Controllers\ReservationController;

// Route::get('/', function () {
//     return redirect()->route('ressources.index');
// });

// Route::get('/ressources', [RessourceController::class, 'index'])
//     ->name('ressources.index');

// Route::get('/ressources/{ressource}', [RessourceController::class, 'show'])
//     ->name('ressources.show');

// Route::get('/reservations', [ReservationController::class, 'index'])
//     ->name('reservations.list'); 

// Route::get('/ressources/{ressource}/reserver', [ReservationController::class, 'create'])
//     ->name('reservations.create');

// Route::post('/reservations', [ReservationController::class, 'store'])
//     ->name('reservations.store');
    
    
// Route::get('/', [RessourceController::class, 'index'])->name('home');





use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\DemandeCompteController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\ReservationController;

// Home page using existing guest landing
Route::get('/', [GuestController::class, 'index'])->name('home');

// Guest pages
Route::get('/catalogue', [GuestController::class, 'catalogue'])->name('catalogue');
Route::get('/regles', [GuestController::class, 'regles'])->name('regles');
Route::get('/demande-compte', [DemandeCompteController::class, 'create'])->name('demande.compte');
Route::post('/demande-compte', [DemandeCompteController::class, 'store'])->name('demande.compte.store');

// Ressources & reservations
Route::get('/ressources', [RessourceController::class, 'index'])->name('ressources.index');
Route::get('/ressources/{ressource}', [RessourceController::class, 'show'])->name('ressources.show');
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.list');
Route::get('/ressources/{ressource}/reserver', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
