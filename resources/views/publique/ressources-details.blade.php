@extends('layouts.app')

@section('title', 'Détails de la ressource')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        color: #2c3e50;
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
        background: var(--bg-primary) !important; /* Fond sombre pour le contraste */
        padding: 50px 40px;
        text-align: center;
        border-bottom: 3px solid var(--accent-primary);
    }

    .details-icon {
        font-size: 80px;
        margin-bottom: 20px;
    }

    .details-header h1 {
        font-size: 36px;
        margin-bottom: 15px;
        color: var(--accent-primary) !important; /* Titre en Orange Pêche */
        font-weight: 800;
    }

    .details-category {
        font-size: 1.1rem;
        color: var(--color-white) !important;
        opacity: 0.9;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
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
        padding: 12px 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        background: rgba(255, 255, 255, 0.5);
        margin-bottom: 5px;
        border-radius: 6px;
    }

    .spec-label {
        color: #424769 !important; /* Gris-Bleu foncé pour les labels */
        font-weight: 600 !important;
        font-size: 0.95rem;
    }

    .spec-value {
        color: #2d3250 !important; /* Bleu très sombre pour les valeurs (Ex: 1Gbps) */
        font-weight: 800 !important;
        text-align: right;
    }

    .details-section h3 {
        color: var(--bg-primary) !important;
        margin-bottom: 20px;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 2px solid var(--accent-primary);
        padding-bottom: 8px;
    }
    .alert-info{
        background: #f8f9fa;
        color: #2c3e50;
        border-color: #2c3e50;
        border-radius: 20px;
        padding: 15px;
        margin-bottom: 20px;     
    }
</style>

<a href="{{ route('catalogue') }}" class="back-link">Retour aux ressources</a>

<div class="ressource-details">
    <div class="details-header">

        {{-- NOM + CATEGORIE --}}
        <h1>{{ $ressource->nom }}</h1>
        <p class="details-category">
            {{ $ressource->categorie->nom ?? 'Ressource' }}
        </p>
    </div>

    <div class="details-body">
        {{-- DESCRIPTION --}}
        <div class="description">
            <h3 style="color: #2c3e50; margin-bottom: 15px;"> Description</h3>
            <p>{{ $ressource->description }}</p>
        </div>
        <div class="details-grid">
            {{-- Caractéristiques techniques --}}
            <div class="details-section">
                <h3> Caractéristiques techniques</h3>
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
                <h3> Disponibilité et statut</h3>

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
                <h3>Système et logiciels</h3>

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
            <strong> Information importante</strong>
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