@extends('layouts.admin')

@section('title', 'Gestion des Incidents')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Liste des Incidents Signalés</h3>
    </div>

    @if($incidents->isEmpty())
        <div style="padding: 20px; text-align: center; color: #666;">
            Aucun incident signalé pour le moment.
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Déclarant</th>
                    <th>Ressource</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidents as $incident)
                    <tr>
                        <td>#{{ $incident->id }}</td>
                        <td>{{ $incident->titre }}</td>
                        <td>{{ $incident->declarant->nom }} {{ $incident->declarant->prenom }}</td>
                        <td>
                            @if($incident->ressource)
                                <a href="{{ route('admin.ressources.show', $incident->ressource) }}">
                                    {{ $incident->ressource->nom }}
                                </a>
                            @else
                                <span class="text-muted">Général</span>
                            @endif
                        </td>
                        <td>
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
                            <span class="badge badge-{{ $colors[$incident->statut] ?? 'primary' }}">
                                {{ $labels[$incident->statut] ?? $incident->statut }}
                            </span>
                        </td>
                        <td>{{ $incident->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.incidents.show', $incident) }}" class="btn btn-sm btn-info">Voir</a>
                            
                            @if($incident->statut !== 'resolved' && $incident->statut !== 'closed')
                                <form action="{{ route('admin.incidents.resolve', $incident) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">Résoudre</button>
                                </form>
                            @endif

                            @if($incident->statut !== 'closed')
                            <form action="{{ route('admin.incidents.close', $incident) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-secondary">Clôturer</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="padding: 10px;">
            {{ $incidents->links() }}
        </div>
    @endif
</div>
@endsection
