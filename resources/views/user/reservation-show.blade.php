@extends('layouts.app')

@section('title', 'Détails de la Réservation')

@section('content')
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
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 20px;
    }

    .header-title h1 {
        font-size: 28px;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .header-title p {
        color: #7f8c8d;
        font-size: 14px;
    }

    .badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .badge-warning { background: #fff3cd; color: #856404; }
    .badge-success { background: #d4edda; color: #155724; }
    .badge-danger { background: #f8d7da; color: #721c24; }
    .badge-info { background: #d1ecf1; color: #0c5460; }
    .badge-secondary { background: #e2e3e5; color: #383d41; }

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

    .ressource-specs {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    .spec-item {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .spec-label {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .spec-value {
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-info {
        background: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
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
<a href="{{ route('user.reservations') }}" class="back-link">
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
            @switch($reservation->statut)
                @case('en_attente')
                    <span class="badge badge-warning">⏳ En attente</span>
                    @break
                @case('approuvee')
                    <span class="badge badge-success">✅ Approuvée</span>
                    @break
                @case('refusee')
                    <span class="badge badge-danger">❌ Refusée</span>
                    @break
                @case('active')
                    <span class="badge badge-info">🔄 Active</span>
                    @break
                @case('terminee')
                    <span class="badge badge-secondary">✓ Terminée</span>
                    @break
            @endswitch
        </div>
    </div>

    <div class="header-actions">
        @if($reservation->statut == 'active')
            <a href="{{ route('user.ressource.access', $reservation->ressource_id) }}" class="btn btn-primary">
                🔑 Accéder à la ressource
            </a>
        @endif

        @if(in_array($reservation->statut, ['en_attente', 'approuvee']))
            <form action="{{ route('user.reservation.cancel', $reservation->id) }}" method="POST" 
                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    🗑️ Annuler la réservation
                </button>
            </form>
        @endif

        @if($reservation->statut == 'active')
            <a href="{{ route('user.reservation.extend', $reservation->id) }}" class="btn btn-warning">
                ⏰ Prolonger
            </a>
        @endif

        <a href="{{ route('user.incident.report', ['reservation_id' => $reservation->id]) }}" class="btn btn-primary">
            ⚠️ Signaler un problème
        </a>
    </div>
</div>

<!-- Alerts -->
@if($reservation->statut == 'refusee' && $reservation->motif_refus)
<div class="alert alert-warning">
    <strong>⚠️ Motif du refus :</strong><br>
    {{ $reservation->motif_refus }}
</div>
@endif

@if($reservation->statut == 'active' && $reservation->date_fin->diffInDays(now()) <= 2)
<div class="alert alert-warning">
    <strong>⏰ Attention :</strong> Votre réservation expire dans {{ $reservation->date_fin->diffForHumans() }}
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
                    <span class="info-value">{{ $reservation->date_debut->format('d/m/Y à H:i') }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        <span>📅</span> Date de fin
                    </span>
                    <span class="info-value">{{ $reservation->date_fin->format('d/m/Y à H:i') }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        <span>⏱️</span> Durée totale
                    </span>
                    <span class="info-value">{{ $reservation->date_debut->diffInDays($reservation->date_fin) }} jours</span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        <span>👤</span> Responsable
                    </span>
                    <span class="info-value">{{ $reservation->ressource->responsable->nom ?? 'Non assigné' }}</span>
                </div>

                @if($reservation->statut == 'approuvee' || $reservation->statut == 'active' || $reservation->statut == 'terminee')
                <div class="info-item">
                    <span class="info-label">
                        <span>✅</span> Approuvée par
                    </span>
                    <span class="info-value">{{ $reservation->approuve_par->nom ?? 'Système' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">
                        <span>📅</span> Date d'approbation
                    </span>
                    <span class="info-value">{{ $reservation->date_approbation ? $reservation->date_approbation->format('d/m/Y à H:i') : '-' }}</span>
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

                @if($reservation->statut == 'approuvee' || $reservation->statut == 'active' || $reservation->statut == 'terminee')
                <div class="timeline-item success">
                    <div class="timeline-content">
                        <div class="timeline-title">Réservation approuvée</div>
                        <div class="timeline-date">{{ $reservation->date_approbation ? $reservation->date_approbation->format('d/m/Y à H:i') : '-' }}</div>
                        <div class="timeline-desc">
                            Approuvée par {{ $reservation->approuve_par->nom ?? 'Système' }}
                        </div>
                    </div>
                </div>
                @endif

                @if($reservation->statut == 'refusee')
                <div class="timeline-item danger">
                    <div class="timeline-content">
                        <div class="timeline-title">Réservation refusée</div>
                        <div class="timeline-date">{{ $reservation->updated_at->format('d/m/Y à H:i') }}</div>
                        <div class="timeline-desc">{{ $reservation->motif_refus }}</div>
                    </div>
                </div>
                @endif

                @if($reservation->statut == 'active')
                <div class="timeline-item success">
                    <div class="timeline-content">
                        <div class="timeline-title">Réservation active</div>
                        <div class="timeline-date">{{ $reservation->date_debut->format('d/m/Y à H:i') }}</div>
                        <div class="timeline-desc">La ressource est maintenant disponible</div>
                    </div>
                </div>
                @endif

                @if($reservation->statut == 'terminee')
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-title">Réservation terminée</div>
                        <div class="timeline-date">{{ $reservation->date_fin->format('d/m/Y à H:i') }}</div>
                        <div class="timeline-desc">La ressource a été libérée</div>
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
                    {{ $reservation->ressource->categorie->icon ?? '🖥️' }}
                </div>
                <h3 style="color: #2c3e50; margin-bottom: 5px;">{{ $reservation->ressource->nom }}</h3>
                <p style="color: #7f8c8d;">{{ $reservation->ressource->categorie->nom ?? 'Non catégorisé' }}</p>
            </div>

            @if($reservation->ressource->specifications)
            <div class="ressource-specs">
                @foreach(json_decode($reservation->ressource->specifications, true) as $key => $value)
                <div class="spec-item">
                    <div class="spec-label">{{ ucfirst($key) }}</div>
                    <div class="spec-value">{{ $value }}</div>
                </div>
                @endforeach
            </div>
            @endif

            <div style="margin-top: 20px;">
                <a href="{{ route('ressources.details', $reservation->ressource_id) }}" 
                   style="display: block; text-align: center; color: #667eea; text-decoration: none; font-weight: 600;">
                    Voir détails complets →
                </a>
            </div>
        </div>

        <!-- Access Info (only for active reservations) -->
        @if($reservation->statut == 'active' && $reservation->ressource->acces_info)
        <div class="details-card">
            <h2>🔑 Informations d'accès</h2>
            
            <div class="alert alert-info" style="margin-bottom: 15px;">
                <strong>ℹ️ Informations confidentielles</strong><br>
                Ne partagez jamais ces informations
            </div>

            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; font-family: monospace; word-break: break-all;">
                {!! nl2br(e($reservation->ressource->acces_info)) !!}
            </div>

            <div style="margin-top: 15px; text-align: center;">
                <button onclick="copyAccessInfo()" class="btn btn-primary">
                    📋 Copier les informations
                </button>
            </div>
        </div>
        @endif

        <!-- Contact Support -->
        <div class="details-card">
            <h2>💬 Besoin d'aide ?</h2>
            <p style="color: #555; margin-bottom: 15px;">
                Si vous rencontrez un problème avec votre réservation, n'hésitez pas à nous contacter.
            </p>
            <a href="{{ route('user.incident.report', ['reservation_id' => $reservation->id]) }}" 
               class="btn btn-primary" style="width: 100%; justify-content: center;">
                ⚠️ Signaler un incident
            </a>
        </div>
    </div>
</div>

<script>
function copyAccessInfo() {
    const accessInfo = document.querySelector('.details-card:last-of-type div[style*="monospace"]').innerText;
    navigator.clipboard.writeText(accessInfo).then(() => {
        alert('✅ Informations copiées dans le presse-papiers');
    });
}
</script>

@if(session('success'))
<script>
    alert('✅ {{ session('success') }}');
</script>
@endif

@if(session('error'))
<script>
    alert('❌ {{ session('error') }}');
</script>
@endif
@endsection