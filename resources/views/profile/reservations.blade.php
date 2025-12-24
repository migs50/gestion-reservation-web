@extends('layouts.app')

@section('title', 'Mes réservations')

@section('content')
<div class="profile-container">
    <div class="page-header">
        <h1>Mes réservations</h1>
        <a href="{{ route('profile') }}" class="btn btn-secondary">Retour au profil</a>
    </div>

    <div class="reservations-list">
        @forelse($reservations as $reservation)
            <div class="reservation-card">
                <div class="reservation-header">
                    <h3>Réservation #{{ $reservation->id }}</h3>
                    <span class="badge badge-{{ $reservation->statut }}">{{ ucfirst($reservation->statut) }}</span>
                </div>
                <div class="reservation-body">
                    <div class="reservation-info">
                        <div class="info-row">
                            <span class="label">Période:</span>
                            <span class="value">{{ $reservation->debut->format('d/m/Y H:i') }} - {{ $reservation->fin->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Justification:</span>
                            <span class="value">{{ $reservation->justification }}</span>
                        </div>
                        @if($reservation->note_decision)
                            <div class="info-row">
                                <span class="label">Note de décision:</span>
                                <span class="value">{{ $reservation->note_decision }}</span>
                            </div>
                        @endif
                        @if($reservation->decideur)
                            <div class="info-row">
                                <span class="label">Décidé par:</span>
                                <span class="value">{{ $reservation->decideur->prenom }} {{ $reservation->decideur->nom }}</span>
                            </div>
                        @endif
                    </div>

                    @if($reservation->affectations->count() > 0)
                        <div class="affectations">
                            <h4>Ressources affectées:</h4>
                            <ul>
                                @foreach($reservation->affectations as $affectation)
                                    <li>{{ $affectation->ressource->nom ?? 'Ressource inconnue' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="reservation-footer">
                    <small>Créée le {{ $reservation->created_at->format('d/m/Y à H:i') }}</small>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>Vous n'avez aucune réservation pour le moment.</p>
                <a href="{{ route('ressources.index') }}" class="btn btn-primary">Faire une réservation</a>
            </div>
        @endforelse

        @if($reservations->hasPages())
            <div class="pagination">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
