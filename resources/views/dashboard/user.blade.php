@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="dashboard-container">
    <div class="page-header">
        <h1>Tableau de bord</h1>
        <p>Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['total_reservations'] }}</div>
                <div class="stat-label">Total réservations</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['pending'] }}</div>
                <div class="stat-label">En attente</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['approved'] }}</div>
                <div class="stat-label">Approuvées</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🟢</div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['active'] }}</div>
                <div class="stat-label">Actives</div>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="dashboard-card">
            <div class="card-header">
                <h2>Ressources disponibles</h2>
                <a href="{{ route('ressources.index') }}" class="btn btn-primary">Voir toutes</a>
            </div>
            <div class="card-body">
                <p>{{ $available_ressources }} ressources actuellement disponibles pour réservation.</p>
                <a href="{{ route('ressources.index') }}" class="btn btn-success">Nouvelle réservation</a>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <h2>Mes réservations récentes</h2>
                <a href="{{ route('profile.reservations') }}" class="link">Voir tout</a>
            </div>
            <div class="reservations-list">
                @forelse($recent_reservations as $reservation)
                    <div class="reservation-item">
                        <div class="reservation-info">
                            <div class="reservation-title">Réservation #{{ $reservation->id }}</div>
                            <div class="reservation-date">{{ $reservation->debut->format('d/m/Y H:i') }} - {{ $reservation->fin->format('d/m/Y H:i') }}</div>
                            <div class="reservation-desc">{{ $reservation->description }}</div>
                        </div>
                        <div class="reservation-status">
                            <span class="badge badge-{{ $reservation->statut }}">{{ ucfirst($reservation->statut) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="empty-state">Aucune réservation pour le moment.</p>
                @endforelse
            </div>
        </div>

        <div class="dashboard-card">
            <div class="card-header">
                <h2>Notifications</h2>
            </div>
            <div class="notifications-list">
                @forelse($notifications as $notification)
                    <div class="notification-item notification-{{ $notification->type }}">
                        <div class="notification-title">{{ $notification->titre }}</div>
                        <div class="notification-content">{{ $notification->contenu }}</div>
                        <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <p class="empty-state">Aucune nouvelle notification.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
