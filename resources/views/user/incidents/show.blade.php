@extends('layouts.app')

@section('title', 'Détails de l\'incident')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    .incident-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.9em;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-open { background: #fff9e6; color: #f9b17a; border: 1px solid #f9b17a; }
    .badge-in_progress { background: #eef2ff; color: #4f46e5; border: 1px solid #4f46e5; }
    .badge-resolved { background: #e3fcef; color: #00b894; border: 1px solid #00b894; }
    .badge-closed { background: #f1f2f6; color: #636e72; border: 1px solid #636e72; }

    .detail-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #2d3250 0%, #424769 100%);
        color: white;
        padding: 30px;
    }

    .card-body {
        padding: 30px;
    }

    .info-group {
        margin-bottom: 25px;
    }

    .info-label {
        font-size: 0.85em;
        text-transform: uppercase;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }

    .info-value {
        font-size: 1.1em;
        color: #2d3250;
        line-height: 1.6;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        margin-bottom: 20px;
        color: #424769;
        text-decoration: none;
        font-weight: 600;
        transition: transform 0.2s;
    }
    .back-btn:hover {
        transform: translateX(-5px);
        color: #f9b17a;
    }
</style>

<div class="incident-container">
    <a href="{{ url()->previous() }}" class="back-btn">
        ← Retour
    </a>

    <div class="detail-card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h1 style="margin: 0; font-size: 1.8em; margin-bottom: 5px;">{{ $incident->titre }}</h1>
                    <div style="opacity: 0.8; font-size: 0.9em;">
                        Signalé le {{ $incident->created_at->format('d/m/Y à H:i') }}
                        par {{ $incident->declarant->nom }} {{ $incident->declarant->prenom }}
                    </div>
                </div>
                <span class="status-badge badge-{{ $incident->statut }}">
                    {{ match($incident->statut) {
                        'open' => 'Ouvert',
                        'in_progress' => 'En cours',
                        'resolved' => 'Résolu',
                        'closed' => 'Fermé',
                        default => $incident->statut
                    } }}
                </span>
            </div>
        </div>

        <div class="card-body">
            @if($incident->ressource)
            <div class="info-group">
                <span class="info-label">Ressource concernée</span>
                <div class="info-value" style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 1.2em;">🖥️</span>
                    <a href="{{ route('ressources.show', $incident->ressource) }}" style="color: #4f46e5; text-decoration: none; font-weight: 600;">
                        {{ $incident->ressource->nom }}
                    </a>
                </div>
            </div>
            @endif

            <div class="info-group">
                <span class="info-label">Description du problème</span>
                <div class="info-value" style="background: #f8fafc; padding: 20px; border-radius: 8px; white-space: pre-wrap;">{{ $incident->description }}</div>
            </div>

            @if($incident->assigne)
            <div class="info-group">
                <span class="info-label">Pris en charge par</span>
                <div class="info-value">
                    👤 {{ $incident->assigne->nom }} {{ $incident->assigne->prenom }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
