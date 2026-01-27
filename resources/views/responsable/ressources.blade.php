

@extends('layouts.app')

@section('title', 'Mes Ressources - Responsable')
@section('breadcrumb', 'Mes Ressources')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">



@section('content')


{{-- Page Header --}}
<div class="page-header">
    <h1 class="page-title">
        <span></span>
        Mes Ressources
    </h1>
    <div class="page-actions">
        <a href="{{ route('responsable.ressources.create') }}" class="btn btn-white">
            <span></span>
            Nouvelle ressource
        </a>
    </div>
</div>
<div class="page-header">
    <h1 class="page-title">
        <a href="{{ route('responsable.reservations.index') }}">Mes réservations</a>
    </h1>
</div>

{{-- Filters --}}
<div class="filters-bar">
    <form action="{{ route('responsable.ressources') }}" method="GET">
        <div class="filters-grid">
            <div class="filter-group">
                <label class="filter-label" style="margin-bottom: 10px;">Rechercher</label>
                <input 
                    type="text" 
                    name="search"
                    class="filter-input" 
                    placeholder="Nom, type, spécifications..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="filter-group">
                <label class="filter-label" style="margin-bottom: 10px;">Type</label>
                <select name="type" class="filter-select">
                    <option value="">Tous les types</option>
                    <option value="serveur" {{ request('type') == 'serveur' ? 'selected' : '' }}>Serveur</option>
                    <option value="storage" {{ request('type') == 'storage' ? 'selected' : '' }}>Stockage</option>
                    <option value="network" {{ request('type') == 'network' ? 'selected' : '' }}>Réseau</option>
                    <option value="vm" {{ request('type') == 'vm' ? 'selected' : '' }}>Machine virtuelle</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label" style="margin-bottom: 10px;">État</label>
                <select name="status" class="filter-select">
                    <option value="">Tous les états</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Réservé</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="disabled" {{ request('status') == 'disabled' ? 'selected' : '' }}>Désactivé</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-bottom: 20px; margin-top: 20px;">
                Filtrer
            </button>
        </div>
    </form>
</div>

{{-- Resources Grid --}}
<div class="resources-grid">
    @forelse($resources as $resource)
        <div class="resource-card">
            <div class="resource-image">
                {{ $resource->nom }}
                <span class="resource-badge badge-{{ $resource->etat }}">
                    {{ ucfirst($resource->etat) }}
                </span>
            </div>
            <div class="resource-body">
                <h3 class="resource-title">{{ $resource->nom }}</h3>
                <p class="resource-type">{{ $resource->categorie ? $resource->categorie->nom : 'Sans catégorie' }}</p>
                <div style="display: inline-block; background: var(--accent-primary); color: white; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; margin-bottom: 10px;">
                    Vous êtes propriétaire
                </div>
                
                <div class="resource-specs">
                    @if($resource->cpu)
                        <div class="spec-item"><span></span><span>CPU: {{ $resource->cpu }}</span></div>
                    @endif
                    @if($resource->ram)
                        <div class="spec-item"><span></span><span>RAM: {{ $resource->ram }}</span></div>
                    @endif
                    @if($resource->os)
                        <div class="spec-item"><span></span><span>OS: {{ $resource->os }}</span></div>
                    @endif
                </div>

                <div class="resource-actions" style="grid-template-columns: 1fr 1fr 1fr;">
                    <a href="{{ route('responsable.ressources.edit', $resource->id) }}" class="action-btn" style="background: #f9b17a; color: white; text-align: center; text-decoration: none;">
                        Éditer
                    </a>
                    @if($resource->etat !== 'maintenance')
                        <form action="{{ route('responsable.resources.maintenance', $resource->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="action-btn action-maintenance" onclick="return confirm('Mettre en maintenance ?')">
                                Maint.
                            </button>
                        </form>
                    @else
                        <form action="{{ route('responsable.resources.enable', $resource->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="action-btn action-enable" onclick="return confirm('Réactiver ?')">
                                Activer
                            </button>
                        </form>
                    @endif

                    @if($resource->etat !== 'disabled')
                        <form action="{{ route('responsable.resources.disable', $resource->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="action-btn action-disable" onclick="return confirm('Désactiver ?')">
                                Désact.
                            </button>
                        </form>
                    @else
                        <form action="{{ route('responsable.resources.enable', $resource->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="action-btn action-enable" onclick="return confirm('Réactiver ?')">
                                Activer
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: #718096;">
            <div style="font-size: 64px; margin-bottom: 20px;"></div>
            <p style="font-size: 18px; font-weight: 600;">Aucune ressource trouvée</p>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($resources->hasPages())
    <div style="margin-top: 30px;">
        {{ $resources->links() }}
    </div>
@endif

@endsection