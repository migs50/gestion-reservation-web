@extends('layouts.admin')

@section('title', 'Détails de la réservation' . $reservation->id)

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 class="card-title">Réservation #{{ $reservation->id }}</h3>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary btn-sm">
            &larr; Retour à la liste
        </a>
    </div>

    <div class="card-body" style="padding: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            
            <!-- Informations de la réservation -->
            <div>
                <h5 style="color: #6c757d; text-transform: uppercase; font-size: 0.85rem; font-weight: 600; margin-bottom: 15px;">Informations Générales</h5>
                
                <div style="margin-bottom: 15px;">
                    <strong>Statut :</strong>
                    @if($reservation->statut === 'pending')
                        <span class="badge badge-warning">En attente</span>
                    @elseif($reservation->statut === 'approved' || $reservation->statut === 'active')
                        <span class="badge badge-success">Approuvée</span>
                    @elseif($reservation->statut === 'refused')
                        <span class="badge badge-danger">Refusée</span>
                    @elseif($reservation->statut === 'cancelled')
                        <span class="badge badge-secondary">Annulée</span>
                    @else
                        <span class="badge badge-secondary">{{ ucfirst($reservation->statut) }}</span>
                    @endif
                </div>

                <div style="margin-bottom: 15px;">
                    <strong>Date de début :</strong>
                    {{ $reservation->debut ? $reservation->debut->format('d/m/Y à H:i') : 'N/A' }}
                </div>

                <div style="margin-bottom: 15px;">
                    <strong>Date de fin :</strong>
                    {{ $reservation->fin ? $reservation->fin->format('d/m/Y à H:i') : 'N/A' }}
                </div>

                <div style="margin-bottom: 15px;">
                    <strong>Créée le :</strong>
                    {{ $reservation->created_at->format('d/m/Y à H:i') }}
                </div>
            </div>

            <!-- Informations sur les acteurs -->
            <div>
                <h5 style="color: #6c757d; text-transform: uppercase; font-size: 0.85rem; font-weight: 600; margin-bottom: 15px;">Acteurs</h5>

                <div style="margin-bottom: 20px;">
                    <strong>Demandeur :</strong><br>
                    @if($reservation->demandeur)
                        {{ $reservation->demandeur->nom }} {{ $reservation->demandeur->prenom }}<br>
                        <small class="text-muted">{{ $reservation->demandeur->email }}</small>
                    @else
                        <span class="text-muted">Utilisateur inconnu</span>
                    @endif
                </div>

                <div style="margin-bottom: 20px;">
                    <strong>Ressource :</strong><br>
                    @if($reservation->ressource)
                        <a href="{{ route('admin.ressources.show', $reservation->ressource->id) }}">
                            {{ $reservation->ressource->nom }}
                        </a>
                        <br>
                        <small class="text-muted">{{ $reservation->ressource->categorie->nom ?? 'Type inconnu' }}</small>
                    @else
                        <span class="text-muted">Ressource inconnue</span>
                    @endif
                </div>

                @if($reservation->decideur)
                    <div style="margin-bottom: 20px;">
                        <strong>Décidé par :</strong><br>
                        {{ $reservation->decideur->nom }} {{ $reservation->decideur->prenom }}
                    </div>
                @endif
            </div>
        </div>

        @if($reservation->note_decision)
            <div style="margin-top: 30px; background: #424769; padding: 15px; border-radius: 8px; border: 1px solid #e9ecef;">
                <strong>Note de décision / Motif :</strong>
                <p style="margin-top: 5px; margin-bottom: 0;">{{ $reservation->note_decision }}</p>
            </div>
        @endif

        <!-- Actions -->
        @if($reservation->statut === 'pending')
            <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                <h5 style="margin-bottom: 15px;">Actions</h5>
                <div style="display: flex; gap: 10px;">
                    <form action="{{ route('admin.reservations.approve', $reservation) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            ✅ Accepter la demande
                        </button>
                    </form>

                    <button type="button" class="btn btn-danger" onclick="document.getElementById('reject-form').style.display='block'">
                        ❌ Refuser la demande
                    </button>
                </div>

                <div id="reject-form" style="display: none; margin-top: 20px;">
                    <form action="{{ route('admin.reservations.refuse', $reservation) }}" method="POST" style="background: #fff5f5; padding: 20px; border-radius: 8px; border: 1px solid #feb2b2;">
                        @csrf
                        <div class="form-group">
                            <label for="note_decision" style="color: #c53030; font-weight: bold;">Motif du refus :</label>
                            <textarea name="note_decision" id="note_decision" rows="3" class="form-control" required placeholder="Veuillez indiquer la raison du refus..."></textarea>
                        </div>
                        <div style="margin-top: 10px;">
                            <button type="submit" class="btn btn-danger">Confirmer le refus</button>
                            <button type="button" class="btn btn-secondary" onclick="document.getElementById('reject-form').style.display='none'">Annuler</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
