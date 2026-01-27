@extends('layouts.admin')

@section('title', 'Détails de l\'incident #' . $incident->id)

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <a href="{{ route('admin.incidents.index') }}" class="btn btn-secondary btn-sm" style="margin-right: 10px;">&larr; Retour</a>
            <h3 style="display: inline-block; vertical-align: middle; margin: 0;">{{ $incident->titre }}</h3>
        </div>
        <div>
            @if($incident->statut !== 'resolved' && $incident->statut !== 'closed')
                <form action="{{ route('admin.incidents.resolve', $incident) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">✅ Résoudre</button>
                </form>
            @endif

            @if($incident->statut !== 'closed')
            <form action="{{ route('admin.incidents.close', $incident) }}" method="POST" style="display:inline; margin-left: 5px;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-secondary">🔒 Clôturer</button>
            </form>
            @endif
        </div>
    </div>

    <div class="card-body" style="padding: 20px;">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
            
            <!-- Main Content -->
            <div>
                <h5 style="color: #6c757d; text-transform: uppercase; font-size: 0.85rem; font-weight: 600; margin-bottom: 10px;">Description</h5>
                <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #e9ecef; white-space: pre-wrap; color: #000000ff;">{{ $incident->description }}</div>

                <div style="margin-top: 30px;">
                    <h5 style="color: #6c757d; text-transform: uppercase; font-size: 0.85rem; font-weight: 600; margin-bottom: 10px;">Historique / Commentaires</h5>
                    <p class="text-muted">Fonctionnalité de commentaires à venir...</p>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div style="background: #f8f9fa; padding: 20px; border-radius: 12px; height: fit-content;">
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 600; color: #495057;">Statut</label>
                    <br>
                    @php
                        $colors = [
                            'open' => 'warning',
                            'in_progress' => 'info',
                            'resolved' => 'success',
                            'closed' => 'secondary'
                        ];
                        $labels = [
                            'open' => 'Ouvert',
                            'in_progress' => 'En cours',
                            'resolved' => 'Résolu',
                            'closed' => 'Fermé'
                        ];
                    @endphp
                    <span class="badge badge-{{ $colors[$incident->statut] ?? 'primary' }}" style="font-size: 1rem; padding: 8px 12px;">
                        {{ $labels[$incident->statut] ?? $incident->statut }}
                    </span>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 600; color: #000000ff;">Déclaré par</label>
                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px;">
                        <div style="width: 35px; height: 35px; color: rgba(0, 0, 0, 1); background: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #495057;">
                            {{ substr($incident->declarant->prenom, 0, 1) }}{{ substr($incident->declarant->nom, 0, 1) }}
                        </div>
                        <div>
                            <div style="color: #000000ff;">{{ $incident->declarant->nom }} {{ $incident->declarant->prenom }}</div>
                            <small class="text-muted">{{ $incident->declarant->email }}</small>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 600; color: #495057;">Ressource concernée</label>
                    @if($incident->ressource)
                        <div style="margin-top: 5px;">
                            <a href="{{ route('admin.ressources.show', $incident->ressource) }}" style="text-decoration: none; font-weight: 600; color: #4f46e5;">
                                🖥️ {{ $incident->ressource->nom }}
                            </a>
                        </div>
                    @else
                        <div class="text-muted">Aucune (Incident général)</div>
                    @endif
                </div>

                <div>
                    <label style="font-weight: 600; color: #495057;">Date de signalement</label>
                    <div style="color: #212529;">{{ $incident->created_at->format('d/m/Y à H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
