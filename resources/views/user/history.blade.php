@extends('layouts.app')

@section('title', 'Mes réservations')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    /* Reset animations */
    .reservations-container {
        padding: 20px 0;
        /* No animation */
    }


    /* Override New Reservation Button for Dark Header */
    .dashboard-header {
        background-color: #383a59; /* Matching the dark blue/purple */
        border-radius: 12px; /* Keeping radius as it looks better than square but "simple" usually allows radius */
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: none; /* Removing shadow */
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: none;
        color: white;
        position: relative;
        z-index: 10;
    }

    .dashboard-header h1 {
        font-size: 28px;
        color: white;
        margin-bottom: 5px;
        font-weight: 700;
        background: none;
        -webkit-text-fill-color: initial;
    }

    .dashboard-header .header-actions .btn-primary {
        background: white !important;
        color: #383a59 !important;
        box-shadow: none !important; /* Removing shadow from button too as user requested "pas shadow hord de button" */
        border: none !important;
        border-radius: 8px !important;
        padding: 12px 24px !important;
        font-weight: 700 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        transition: transform 0.2s ease !important;
        position: relative;
        z-index: 20;
        cursor: pointer;
        pointer-events: auto;
        text-decoration: none;
    }

    .dashboard-header .header-actions .btn-primary:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15) !important;
        background-color: #f8f9fa !important;
    }
    /* Filter Bar */
    .filters-bar {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        border: none;
        position: relative;
        z-index: 5; /* Ensure filters are reachable */
    }

    .filters-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 20px;
        align-items: end;
        position: relative;
        z-index: 6; /* Content inside should be interactive */
    }

    .filter-input {
        padding: 12px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        width: 100%;
        background-color: #f8f9fa;
        color: #2c3e50;
        transition: all 0.3s ease;
        position: relative;
        z-index: 10; /* Inputs need to be top-level interactive */
    }
    
    .filter-input:focus {
        outline: none;
        border-color: #667eea;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .btn-search {
        background: #667eea;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.3s ease;
        position: relative;
        z-index: 10; /* Button needs to be interactive */
    }
    
    .btn-search:hover {
        background: #5a67d8;
    }
</style>

<div class="reservations-container">
    <div class="dashboard-header">
        <h1>Historique de mes réservations</h1>
        <div class="header-actions">
            <a href="{{ route('catalogue') }}" class="btn btn-primary">
                Nouvelle réservation
            </a>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="filters-bar">
        <form action="{{ route('reservations.index') }}" method="GET" class="filters-form">
            <div>
                <label class="filter-label">Ressource</label>
                <input type="text" name="ressource" class="filter-input" placeholder="Nom..." value="{{ request('ressource') }}">
            </div>
            <div>
                <label class="filter-label">Statut</label>
                <select name="statut" class="filter-input">
                    <option value="">Tous</option>
                    <option value="pending" {{ request('statut') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="approved" {{ request('statut') == 'approved' ? 'selected' : '' }}>Approuvée</option>
                    <option value="active" {{ request('statut') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="refused" {{ request('statut') == 'refused' ? 'selected' : '' }}>Refusée</option>
                    <option value="terminated" {{ request('statut') == 'terminated' ? 'selected' : '' }}>Terminée</option>
                </select>
            </div>
            <div>
                <label class="filter-label">Du</label>
                <input type="date" name="date_debut" class="filter-input" value="{{ request('date_debut') }}">
            </div>
            <div>
                <label class="filter-label">Au</label>
                <input type="date" name="date_fin" class="filter-input" value="{{ request('date_fin') }}">
            </div>
            <button type="submit" class="btn-search">Filtrer</button>
            <a href="{{ route('reservations.index') }}" class="btn-action btn-view" style="text-align: center; justify-content: center;">Réinitialiser</a>
        </form>
    </div>


    <div class="glass-card">
        @if($reservations->isEmpty())
            <div style="text-align: center; padding: 60px 0;">
                <div style="font-size: 60px; margin-bottom: 20px;">📅</div>
                <h3 style="color: #2d3436;">Aucune réservation pour le moment</h3>
                <p style="color: #636e72;">Commencez par explorer notre catalogue de ressources.</p>
                <a href="{{ route('catalogue') }}" class="btn-action btn-view" style="display: inline-block; margin-top: 20px;">Explorer le catalogue</a>
            </div>
        @else
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ressource</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>#{{ $reservation->id }}</td>
                            <td>
                                <div class="ressource-name">
                                    🔧 {{ $reservation->ressource->nom ?? 'Ressource inconnue' }}
                                </div>
                            </td>
                            <td>
                                <div class="date-info">
                                    <span class="date">{{ $reservation->debut?->format('d/m/Y') }}</span>
                                    <span class="time">{{ $reservation->debut?->format('H:i') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="date-info">
                                    <span class="date">{{ $reservation->fin?->format('d/m/Y') }}</span>
                                    <span class="time">{{ $reservation->fin?->format('H:i') }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $reservation->statut }}">
                                    {{ $reservation->statut == 'pending' ? 'En attente' : 
                                       ($reservation->statut == 'approved' ? 'Approuvée' : 
                                       ($reservation->statut == 'refused' ? 'Refusée' : 
                                       ($reservation->statut == 'active' ? 'Active' : $reservation->statut))) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn-action btn-view">
                                    Détails
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 30px;">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
