@extends('layouts.app')

@section('title', 'Tableau de bord - Responsable')

@section('content')
<div class="dashboard-container">
    <div class="page-header">
        <h1>Tableau de bord - Responsable</h1>
        <p>Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">🖥️</div>
            <div class="stat-content">
                <div class="stat-value">{{ $managed_ressources }}</div>
                <div class="stat-label">Ressources gérées</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-content">
                <div class="stat-value">{{ $pending_requests }}</div>
                <div class="stat-label">Demandes en attente</div>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="dashboard-card">
            <div class="card-header">
                <h2>Demandes récentes</h2>
                <a href="{{ route('manager.requests') }}" class="link">Voir tout</a>
            </div>
            <div class="reservations-list">
                @forelse($recent_requests as $request)
                    <div class="reservation-item">
                        <div class="reservation-info">
                            <div class="reservation-title">Réservation #{{ $request->id }}</div>
                            <div class="reservation-date">{{ $request->debut->format('d/m/Y H:i') }} - {{ $request->fin->format('d/m/Y H:i') }}</div>
                            <div class="reservation-desc">{{ $request->justification }}</div>
                        </div>
                        <div class="reservation-status">
                            <span class="badge badge-{{ $request->statut }}">{{ ucfirst($request->statut) }}</span>
                        </div>
                    </div>
                @empty
                    <p class="empty-state">Aucune demande pour le moment.</p>
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
