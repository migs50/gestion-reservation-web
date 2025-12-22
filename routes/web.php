<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\DemandeCompteController;

/*
|--------------------------------------------------------------------------
| Routes publiques (Invité)
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', [GuestController::class, 'index'])->name('home');

// Catalogue des ressources
Route::get('/catalogue', [GuestController::class, 'catalogue'])->name('catalogue');

// Règles d'utilisation
Route::get('/regles', [GuestController::class, 'regles'])->name('regles');

// Demande de compte
Route::get('/demande-compte', [DemandeCompteController::class, 'create'])->name('demande.compte');
Route::post('/demande-compte', [DemandeCompteController::class, 'store'])->name('demande.compte.store');