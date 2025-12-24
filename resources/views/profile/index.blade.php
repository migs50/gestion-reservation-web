@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="profile-container">
    <div class="page-header">
        <h1>Mon Profil</h1>
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Modifier le profil</a>
    </div>

    <div class="profile-content">
        <div class="profile-card">
            <h2>Informations personnelles</h2>
            <div class="profile-info">
                <div class="info-row">
                    <span class="label">Nom complet:</span>
                    <span class="value">{{ $user->prenom }} {{ $user->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Rôle:</span>
                    <span class="value badge badge-{{ $user->role->nom }}">{{ $user->role->nom }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Statut:</span>
                    <span class="value badge badge-{{ $user->statut }}">{{ ucfirst($user->statut) }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Membre depuis:</span>
                    <span class="value">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <div class="profile-card">
            <h2>Statistiques</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-value">{{ $stats['total_reservations'] }}</div>
                    <div class="stat-label">Total réservations</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $stats['pending'] }}</div>
                    <div class="stat-label">En attente</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $stats['approved'] }}</div>
                    <div class="stat-label">Approuvées</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $stats['active'] }}</div>
                    <div class="stat-label">Actives</div>
                </div>
            </div>
        </div>

        <div class="profile-card">
            <div class="card-header">
                <h2>Réservations récentes</h2>
                <a href="{{ route('profile.reservations') }}" class="link">Voir tout</a>
            </div>
            <div class="reservations-list">
                @forelse($reservations as $reservation)
                    <div class="reservation-item">
                        <div class="reservation-info">
                            <div class="reservation-title">Réservation #{{ $reservation->id }}</div>
                            <div class="reservation-date">{{ $reservation->debut->format('d/m/Y H:i') }} - {{ $reservation->fin->format('d/m/Y H:i') }}</div>
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
    </div>
</div>
@endsection
