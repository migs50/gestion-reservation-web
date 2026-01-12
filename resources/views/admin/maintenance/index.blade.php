@extends('layouts.admin')

@section('title', 'Gestion de la Maintenance')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Périodes d'Indisponibilité</h3>
        <a href="{{ route('admin.maintenances.create') }}" class="btn btn-primary">🔧 Planifier une Maintenance</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="padding: 15px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Ressource</th>
                    <th>Type</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maintenances as $maintenance)
                <tr>
                    <td><strong>{{ $maintenance->ressource->nom }}</strong></td>
                    <td>
                        <span class="badge" style="background: #f1f2f6; color: #2c3e50;">
                            @switch($maintenance->type)
                                @case('maintenance') Maintenance @break
                                @case('inventory') Inventaire @break
                                @case('repair') Réparation @break
                                @default Autre
                            @endswitch
                        </span>
                    </td>
                    <td>{{ $maintenance->debut->format('d/m/Y H:i') }}</td>
                    <td>{{ $maintenance->fin->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($maintenance->fin->isPast())
                            <span class="badge" style="background: #dfe6e9; color: #636e72;">Terminée</span>
                        @elseif($maintenance->debut->isPast())
                            <span class="badge" style="background: #ffeaa7; color: #d6a316;">En cours</span>
                        @else
                            <span class="badge" style="background: #e3fcef; color: #00b894;">Planifiée</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('admin.maintenance.edit', $maintenance) }}" class="btn btn-sm btn-primary" style="padding: 5px 10px; font-size: 12px;">Modifier</a>
                            <form action="{{ route('admin.maintenance.destroy', $maintenance) }}" method="POST" onsubmit="return confirm('Supprimer cette planification ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="padding: 5px 10px; font-size: 12px;">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $maintenances->links() }}
    </div>
</div>
@endsection
