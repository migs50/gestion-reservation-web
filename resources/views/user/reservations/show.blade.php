@extends('layouts.app')

@section('title', 'Détails de la Réservation')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #667eea;
        text-decoration: none;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .reservation-header {
        background-color: #383a59;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        color: white;
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 20px;
    }

    .header-title h1 {
        font-size: 28px;
        color: white;
        margin-bottom: 5px;
    }

    .header-title p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
    }

    .badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .badge-pending { background: #fff9e6; color: #f1c40f; }
    .badge-approved { background: #e3fcef; color: #00b894; }
    .badge-refused { background: #ffebeb; color: #d63031; }
    .badge-active { background: #eef2ff; color: #4f46e5; }
    .badge-terminated { background: #f1f2f6; color: #636e72; }

    .header-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background: #5568d3;
    }

    .btn-danger {
        background: #e74c3c;
        color: white;
    }

    .btn-danger:hover {
        background: #c0392b;
        color: white;
    }

    .btn-warning {
        background: #f39c12;
        color: white;
    }

    .btn-warning:hover {
        background: #d68910;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    .details-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .details-card h2 {
        font-size: 20px;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .info-grid {
        display: grid;
        gap: 20px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .info-label {
        color: #6c757d;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-value {
        color: #2c3e50;
        font-weight: 600;
        text-align: right;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline:before {
        content: '';
        position: absolute;
        left: 8px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 25px;
    }

    .timeline-item:before {
        content: '';
        position: absolute;
        left: -26px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #667eea;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #667eea;
    }

    .timeline-item.success:before {
        background: #2ecc71;
        box-shadow: 0 0 0 2px #2ecc71;
    }

    .timeline-item.danger:before {
        background: #e74c3c;
        box-shadow: 0 0 0 2px #e74c3c;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }

    .timeline-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .timeline-date {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .timeline-desc {
        font-size: 14px;
        color: #555;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-warning {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    @media (max-width: 992px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .header-top {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>

<!-- Back Link -->
<a href="{{ route('reservations.index') }}" class="back-link">
    ← Retour aux réservations
</a>

<!-- Reservation Header -->
<div class="reservation-header">
    <div class="header-top">
        <div class="header-title">
            <h1>{{ $reservation->ressource->nom }}</h1>
            <p>Réservation #{{ $reservation->id }} • Créée le {{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <div>
            <span class="badge badge-{{ $reservation->statut }}">
                @switch($reservation->statut)
                    @case('pending')
                        ⏳ En attente
                        @break
                    @case('approved')
                        ✅ Approuvée
                        @break
                    @case('refused')
                        ❌ Refusée
                        @break
                    @case('active')
                        🔄 Active
                        @break
                    @default
                        {{ ucfirst($reservation->statut) }}
                @endswitch
            </span>
        </div>
    </div>

    <div class="header-actions">
        @if(in_array($reservation->statut, ['pending', 'approved']))
            <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST" 
                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    🗑️ Annuler la réservation
                </button>
            </form>
        @endif

        <a href="{{ route('user.incidents.create', ['reservation_id' => $reservation->id]) }}" class="btn btn-primary">
            ⚠️ Signaler un problème
        </a>
    </div>
</div>

<!-- Alerts -->
@if($reservation->statut == 'refused' && $reservation->note_decision)
<div class="alert alert-warning">
    <strong>⚠️ Motif du refus :</strong><br>
    {{ $reservation->note_decision }}
</div>
@endif

<!-- Content Grid -->
<div class="content-grid">
    <!-- Left Column -->
    <div>
        <!-- Reservation Details -->
        <div class="details-card" style="margin-bottom: 30px;">
            <h2>📋 Détails de la réservation</h2>
            
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">
                        <span>📅</span> Date de début
                    </span>
                    <span class="info-value">{{ $reservation->debut?->format('d/m/Y à H:i') }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        <span>📅</span> Date de fin
                    </span>
                    <span class="info-value">{{ $reservation->fin?->format('d/m/Y à H:i') }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        <span>⏱️</span> Durée totale
                    </span>
                    <span class="info-value">
                        @php
                            $diff = $reservation->debut?->diffInDays($reservation->fin);
                        @endphp
                        {{ $diff }} jour(s)
                    </span>
                </div>

                @if($reservation->statut == 'approved' || $reservation->statut == 'active')
                <div class="info-item">
                    <span class="info-label">
                        <span>✅</span> Approuvée par
                    </span>
                    <span class="info-value">{{ $reservation->decideur->nom ?? 'Gestionnaire' }}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Justification -->
        <div class="details-card" style="margin-bottom: 30px;">
            <h2>📝 Justification</h2>
            <p style="color: #555; line-height: 1.6; white-space: pre-line;">{{ $reservation->justification }}</p>
        </div>

        <!-- Timeline -->
        <div class="details-card">
            <h2>📊 Historique et activités</h2>
            
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-title">Réservation créée</div>
                        <div class="timeline-date">{{ $reservation->created_at->format('d/m/Y à H:i') }}</div>
                        <div class="timeline-desc">La demande de réservation a été soumise</div>
                    </div>
                </div>

                @if($reservation->statut == 'approved' || $reservation->statut == 'active')
                <div class="timeline-item success">
                    <div class="timeline-content">
                        <div class="timeline-title">Réservation approuvée</div>
                        <div class="timeline-date">{{ $reservation->updated_at->format('d/m/Y à H:i') }}</div>
                        <div class="timeline-desc">
                            Approuvée par {{ $reservation->decideur->nom ?? 'Gestionnaire' }}
                        </div>
                    </div>
                </div>
                @endif

                @if($reservation->statut == 'refused')
                <div class="timeline-item danger">
                    <div class="timeline-content">
                        <div class="timeline-title">Réservation refusée</div>
                        <div class="timeline-date">{{ $reservation->updated_at->format('d/m/Y à H:i') }}</div>
                        <div class="timeline-desc">{{ $reservation->note_decision }}</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div>
        <!-- Resource Info -->
        <div class="details-card" style="margin-bottom: 30px;">
            <h2>🖥️ Informations sur la ressource</h2>
            
            <div style="text-align: center; margin: 20px 0;">
                <div style="font-size: 64px; margin-bottom: 15px;">
                    🔧
                </div>
                <h3 style="color: #2c3e50; margin-bottom: 5px;">{{ $reservation->ressource->nom }}</h3>
                <p style="color: #7f8c8d;">{{ $reservation->ressource->categorie->nom ?? 'Informatique' }}</p>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="details-card">
            <h2>💬 Besoin d'aide ?</h2>
            <p style="color: #555; margin-bottom: 15px;">
                Si vous rencontrez un problème avec votre réservation, n'hésitez pas à nous contacter.
            </p>
            <a href="{{ route('user.incidents.create', ['reservation_id' => $reservation->id]) }}" 
               class="btn btn-primary" style="width: 100%; justify-content: center;">
                ⚠️ Signaler un incident
            </a>
        </div>
    </div>
</div>
@endsection

