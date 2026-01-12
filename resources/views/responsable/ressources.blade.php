{{-- 
    📄 Fichier : ressources.blade.php
    📁 Chemin : resources/views/responsable/ressources.blade.php
    🎯 Rôle : Responsable de ressources (avec données dynamiques)
    📝 Description : Liste et gestion des ressources avec actions (maintenance, désactivation)
    🔐 Route : Route::middleware(['auth', 'role:responsable'])->group()
--}}

@extends('layouts.app')

@section('title', 'Mes Ressources - Responsable')
@section('breadcrumb', 'Mes Ressources')

@section('content')
<style>
    /* [Reprendre les mêmes styles que précédemment] */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .page-actions {
        display: flex;
        gap: 12px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .filters-bar {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .filters-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 15px;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-label {
        font-size: 13px;
        font-weight: 600;
        color: #4a5568;
    }

    .filter-input, .filter-select {
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .filter-input:focus, .filter-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .resources-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .resource-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
    }

    .resource-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .resource-image {
        height: 180px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 64px;
        position: relative;
    }

    .resource-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        backdrop-filter: blur(10px);
    }

    .badge-available {
        background: rgba(72, 187, 120, 0.9);
        color: white;
    }

    .badge-reserved {
        background: rgba(237, 137, 54, 0.9);
        color: white;
    }

    .badge-maintenance {
        background: rgba(245, 101, 101, 0.9);
        color: white;
    }

    .badge-disabled {
        background: rgba(160, 174, 192, 0.9);
        color: white;
    }

    .resource-body {
        padding: 22px;
    }

    .resource-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 5px;
    }

    .resource-type {
        font-size: 13px;
        color: #718096;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .resource-specs {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin: 15px 0;
        padding: 15px;
        background: #f7fafc;
        border-radius: 10px;
    }

    .spec-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #4a5568;
    }

    .resource-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .action-btn {
        padding: 10px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .action-maintenance {
        background: #ed8936;
        color: white;
    }

    .action-disable {
        background: #718096;
        color: white;
    }

    .action-enable {
        background: #48bb78;
        color: white;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .filters-grid {
            grid-template-columns: 1fr;
        }
        .resources-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- Page Header --}}
<div class="page-header">
    <h1 class="page-title">
        <span>🖥️</span>
        Mes Ressources
    </h1>
    <div class="page-actions">
        <a href="{{ route('responsable.ressources.create') }}" class="btn btn-primary">
            <span>➕</span>
            Nouvelle ressource
        </a>
    </div>
</div>

{{-- Filters --}}
<div class="filters-bar">
    <form action="{{ route('responsable.ressources') }}" method="GET">
        <div class="filters-grid">
            <div class="filter-group">
                <label class="filter-label">🔍 Rechercher</label>
                <input 
                    type="text" 
                    name="search"
                    class="filter-input" 
                    placeholder="Nom, type, spécifications..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="filter-group">
                <label class="filter-label">📁 Type</label>
                <select name="type" class="filter-select">
                    <option value="">Tous les types</option>
                    <option value="serveur" {{ request('type') == 'serveur' ? 'selected' : '' }}>Serveur</option>
                    <option value="storage" {{ request('type') == 'storage' ? 'selected' : '' }}>Stockage</option>
                    <option value="network" {{ request('type') == 'network' ? 'selected' : '' }}>Réseau</option>
                    <option value="vm" {{ request('type') == 'vm' ? 'selected' : '' }}>Machine virtuelle</option>
                </select>
            </div>

            <div class="filter-group">
                <label class="filter-label">📊 État</label>
                <select name="status" class="filter-select">
                    <option value="">Tous les états</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                    <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Réservé</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="disabled" {{ request('status') == 'disabled' ? 'selected' : '' }}>Désactivé</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                🔍 Filtrer
            </button>
        </div>
    </form>
</div>

{{-- Resources Grid --}}
<div class="resources-grid">
    @forelse($resources as $resource)
        <div class="resource-card">
            <div class="resource-image">
                {{ $resource->getIcon() }}
                <span class="resource-badge badge-{{ $resource->status }}">
                    {{ ucfirst($resource->status) }}
                </span>
            </div>
            <div class="resource-body">
                <h3 class="resource-title">{{ $resource->name }}</h3>
                <p class="resource-type">{{ ucfirst($resource->type) }}</p>
                
                <div class="resource-specs">
                    @if($resource->specifications)
                        @foreach($resource->specifications as $key => $value)
                            <div class="spec-item">
                                <span>⚡</span>
                                <span>{{ ucfirst($key) }}: {{ $value }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="resource-actions">
                    @if($resource->status !== 'maintenance')
                        <form action="{{ route('responsable.resources.maintenance', $resource->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="action-btn action-maintenance" onclick="return confirm('Mettre en maintenance ?')">
                                🔧 Maintenance
                            </button>
                        </form>
                    @else
                        <form action="{{ route('responsable.resources.enable', $resource->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="action-btn action-enable" onclick="return confirm('Réactiver ?')">
                                ✓ Réactiver
                            </button>
                        </form>
                    @endif

                    @if($resource->status !== 'disabled')
                        <form action="{{ route('responsable.resources.disable', $resource->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="action-btn action-disable" onclick="return confirm('Désactiver ?')">
                                ⛔ Désactiver
                            </button>
                        </form>
                    @else
                        <form action="{{ route('responsable.resources.enable', $resource->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="action-btn action-enable" onclick="return confirm('Réactiver ?')">
                                ✓ Activer
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: #718096;">
            <div style="font-size: 64px; margin-bottom: 20px;">📂</div>
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