@extends('layouts.admin')

@section('title', 'Décisions des Responsables')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .filters {
        background: white;
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .decision-approved {
        background: #d4edda;
        color: #155724;
    }

    .decision-rejected {
        background: #f8d7da;
        color: #721c24;
    }

    .justification {
        background: #f8f9fa;
        padding: 8px 10px;
        border-radius: 8px;
        border-left: 3px solid var(--accent-primary);
        margin-top: 10px;
        font-style: italic;
        color: #2d3250;
        font-size: 0.8rem;
        line-height: 1.3;
        max-width: 300px;
    }

    /* Optimisation du tableau */
    .decisions-table {
        font-size: 0.875rem;
    }

    .decisions-table th,
    .decisions-table td {
        padding: 10px 8px;
        vertical-align: middle;
    }

    .decisions-table th {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        white-space: nowrap;
    }

    /* Largeurs des colonnes */
    .decisions-table th:nth-child(1),
    .decisions-table td:nth-child(1) { width: 60px; }
    
    .decisions-table th:nth-child(2),
    .decisions-table td:nth-child(2) { width: 150px; }
    
    .decisions-table th:nth-child(3),
    .decisions-table td:nth-child(3) { width: 120px; }
    
    .decisions-table th:nth-child(4),
    .decisions-table td:nth-child(4) { width: 120px; }
    
    .decisions-table th:nth-child(5),
    .decisions-table td:nth-child(5) { width: 110px; }
    
    .decisions-table th:nth-child(6),
    .decisions-table td:nth-child(6) { width: auto; min-width: 200px; }
    
    .decisions-table th:nth-child(7),
    .decisions-table td:nth-child(7) { width: 120px; }
    
    .decisions-table th:nth-child(8),
    .decisions-table td:nth-child(8) { width: 80px; }

    /* Badge de décision plus compact */
    .decision-badge {
        padding: 4px 10px;
        font-size: 0.75rem;
        border-radius: 15px;
        font-weight: 600;
        display: inline-block;
    }
</style>

<div class="page-header">
    <h1 style="color: #2c3e50; margin: 0;">Décisions des Responsables Techniques</h1>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
        Retour aux réservations
    </a>
</div>

<!-- Filters -->
<form method="GET" action="{{ route('admin.reservations.decisions') }}" class="filters">
    <select name="statut" class="form-control" style="max-width: 200px;">
        <option value="">Tous les statuts</option>
        <option value="approved" {{ request('statut') == 'approved' ? 'selected' : '' }}>Approuvées</option>
        <option value="refused" {{ request('statut') == 'refused' ? 'selected' : '' }}>Refusées</option>
    </select>

    <select name="decideur_id" class="form-control" style="max-width: 250px;">
        <option value="">Tous les responsables</option>
        @foreach($decideurs as $decideur)
            <option value="{{ $decideur->id }}" {{ request('decideur_id') == $decideur->id ? 'selected' : '' }}>
                {{ $decideur->nom }} {{ $decideur->prenom }}
            </option>
        @endforeach
    </select>

    <input type="text" name="search" class="form-control" placeholder="Rechercher..." 
           value="{{ request('search') }}" style="max-width: 300px;">

    <button type="submit" class="btn btn-primary">Filtrer</button>
    <a href="{{ route('admin.reservations.decisions') }}" class="btn btn-secondary">Réinitialiser</a>
</form>

<!-- Table -->
<div class="card">
    <table class="table decisions-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ressource</th>
                <th>Demandeur</th>
                <th>Responsable</th>
                <th>Décision</th>
                <th>Justification</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($decisions as $decision)
            <tr>
                <td>#{{ $decision->id }}</td>
                <td>{{ $decision->ressource->nom }}</td>
                <td>{{ $decision->demandeur->nom }} {{ $decision->demandeur->prenom }}</td>
                <td>{{ $decision->decideur->nom ?? '-' }} {{ $decision->decideur->prenom ?? '' }}</td>
                <td>
                    <span class="decision-badge decision-{{ $decision->statut }}">
                        @if($decision->statut == 'approved')
                            Approuvée
                        @else
                            Refusée
                        @endif
                    </span>
                </td>
                <td>
                    @if($decision->note_decision)
                        <div class="justification">
                            "{{ Str::limit($decision->note_decision, 80) }}"
                        </div>
                    @else
                        <em style="color: #999;">Aucune note</em>
                    @endif
                </td>
                <td>{{ $decision->updated_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.reservations.show', $decision) }}" class="btn btn-sm btn-primary">
                        Voir
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 40px; color: #7f8c8d;">
                    Aucune décision trouvée
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
