@extends('layouts.app')

@section('title', 'Tableau de bord - Admin')

@section('content')
<div class="dashboard-container">
    <div class="page-header">
        <h1>Tableau de bord - Administrateur</h1>
        <p>Bienvenue, {{ auth()->user()->prenom }} {{ auth()->user()->nom }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Utilisateurs</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🖥️</div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['total_ressources'] }}</div>
                <div class="stat-label">Ressources</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🟢</div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['active_reservations'] }}</div>
                <div class="stat-label">Réservations actives</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['pending_requests'] }}</div>
                <div class="stat-label">Demandes en attente</div>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="dashboard-card">
            <div class="card-header">
                <h2>Activité récente</h2>
                <a href="{{ route('admin.users') }}" class="link">Gérer les utilisateurs</a>
            </div>
            <div class="activity-list">
                @forelse($recent_activity as $activity)
                    <div class="activity-item">
                        <div class="activity-info">
                            <div class="activity-user">
                                {{ $activity->acteur ? $activity->acteur->prenom . ' ' . $activity->acteur->nom : 'Système' }}
                            </div>
                            <div class="activity-action">{{ $activity->action_label }} - {{ $activity->objet }}</div>
                            <div class="activity-details">{{ $activity->details }}</div>
                        </div>
                        <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <p class="empty-state">Aucune activité récente.</p>
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
