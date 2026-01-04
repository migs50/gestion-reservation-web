@extends('layouts.app')

@section('title', 'Détails de la ressource')

@section('content')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        color: #667eea;
        text-decoration: none;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .ressource-details {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .details-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px;
        color: white;
        text-align: center;
    }

    .details-icon {
        font-size: 80px;
        margin-bottom: 20px;
    }

    .details-header h1 {
        font-size: 32px;
        margin-bottom: 10px;
    }

    .details-category {
        font-size: 16px;
        opacity: 0.9;
    }

    .details-body {
        padding: 40px;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .details-section {
        background: #f8f9fa;
        padding: 25px;
        border-radius: 10px;
    }

    .details-section h3 {
        color: #2c3e50;
        margin-bottom: 20px;
        font-size: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .spec-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #dee2e6;
    }

    .spec-item:last-child {
        border-bottom: none;
    }

    .spec-label {
        color: #7f8c8d;
        font-weight: 500;
    }

    .spec-value {
        color: #2c3e50;
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .status-available {
        background: #d4edda;
        color: #155724;
    }

    .description {
        line-height: 1.8;
        color: #555;
        margin-bottom: 30px;
    }

    .alert-info {
        background: #d1ecf1;
        color: #0c5460;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #17a2b8;
        margin-top: 30px;
    }

    .alert-info strong {
        display: block;
        margin-bottom: 10px;
    }

    .btn-reserve {
        display: inline-block;
        padding: 15px 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 16px;
        transition: transform 0.3s ease;
    }

    .btn-reserve:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }
</style>

<a href="{{ route('catalogue') }}" class="back-link">← Retour aux ressources</a>

<div class="ressource-details">
    <div class="details-header">
        <div class="details-icon">🖥️</div>

        {{-- NOM + CATEGORIE --}}
        <h1>{{ $ressource->nom }}</h1>
        <p class="details-category">
            {{ $ressource->categorie ?? 'Ressource' }}
        </p>
    </div>

    <div class="details-body">
        {{-- DESCRIPTION --}}
        <div class="description">
            <h3 style="color: #2c3e50; margin-bottom: 15px;">📝 Description</h3>
            <p>{{ $ressource->description }}</p>
        </div>

        <div class="details-grid">
            {{-- Caractéristiques techniques --}}
            <div class="details-section">
                <h3>⚙️ Caractéristiques techniques</h3>
                <div class="spec-item">
                    <span class="spec-label">Bande passante</span>
                    <span class="spec-value">
                        {{ $ressource->bande_passante ?? 'Non renseigné' }}
                    </span>
                </div>
                {{-- ajoute d’autres specs ici si tu as des colonnes CPU / RAM / etc. --}}
            </div>

            {{-- Disponibilité --}}
            <div class="details-section">
                <h3>📊 Disponibilité et statut</h3>

                <div class="spec-item">
                    <span class="spec-label">Statut actuel</span>
                    <span class="status-badge status-available">
                        {{ $ressource->statut ?? 'Inconnu' }}
                    </span>
                </div>

                <div class="spec-item">
                    <span class="spec-label">Emplacement</span>
                    <span class="spec-value">
                        {{ $ressource->emplacement ?? 'Non renseigné' }}
                    </span>
                </div>

                <div class="spec-item">
                    <span class="spec-label">Dernière maintenance</span>
                    <span class="spec-value">
                        {{ optional($ressource->derniere_maintenance)->format('d/m/Y') ?? 'Non renseigné' }}
                    </span>
                </div>

                <div class="spec-item">
                    <span class="spec-label">Prochaine maintenance</span>
                    <span class="spec-value">
                        {{ optional($ressource->prochaine_maintenance)->format('d/m/Y') ?? 'Non renseigné' }}
                    </span>
                </div>

                <div class="spec-item">
                    <span class="spec-label">Uptime</span>
                    <span class="spec-value">
                        {{ $ressource->uptime ?? 'Non renseigné' }}
                    </span>
                </div>
            </div>

            {{-- Système et logiciels --}}
            <div class="details-section">
                <h3>💿 Système et logiciels</h3>

                <div class="spec-item">
                    <span class="spec-label">OS</span>
                    <span class="spec-value">
                        {{ $ressource->os ?? 'Non renseigné' }}
                    </span>
                </div>

                <div class="spec-item">
                    <span class="spec-label">Hyperviseur</span>
                    <span class="spec-value">
                        {{ $ressource->hyperviseur ?? 'Non renseigné' }}
                    </span>
                </div>

                <div class="spec-item">
                    <span class="spec-label">Monitoring</span>
                    <span class="spec-value">
                        {{ $ressource->monitoring ?? 'Non renseigné' }}
                    </span>
                </div>

                <div class="spec-item">
                    <span class="spec-label">Backup</span>
                    <span class="spec-value">
                        {{ $ressource->backup ?? 'Non renseigné' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="alert-info">
            <strong>ℹ️ Information importante</strong>
            Pour réserver cette ressource, vous devez être connecté avec un compte utilisateur validé.
            La durée maximale de réservation est de 30 jours. Les réservations sont soumises à l'approbation
            du responsable des ressources.
        </div>

        <div style="text-align: center; margin-top: 30px;">
            @auth
                <a href="{{ route('reservations.create', $ressource) }}" class="btn-primary">
                    Réserver cette ressource
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-primary">
                    Se connecter pour réserver
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection