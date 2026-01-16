@extends('layouts.app')

@section('title', 'Ressources disponibles')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">



<div class="page-header">
    <h1> Ressources disponibles</h1>
    <p>Découvrez toutes les ressources informatiques de notre Data Center</p>
</div>

<!-- Filters -->
<div class="filters">
    <h3>🔍 Filtrer les ressources</h3>
    <div class="filter-group">
    <select id="categoryFilter">
    <option value="">Toutes les catégories</option>
    <option value="serveur">Serveurs</option>
    <option value="stockage">Stockage</option>
    <option value="réseau">Réseau</option>
    <option value="vm">Machines Virtuelles</option>
</select>


        <select id="statusFilter">
            <option value="">Tous les statuts</option>
            <option value="disponible">Disponible</option>
            <option value="occupe">Occupé</option>
            <option value="maintenance">Maintenance</option>
        </select>

        <input type="text" id="searchInput" placeholder="Rechercher une ressource...">

        <button class="btn-filter" onclick="filterRessources()">
            Filtrer</button>
    </div>
</div>

<!-- Ressources Grid -->
 <div class="ressources-grid" id="ressourcesGrid">
    @foreach ($ressources as $ressource)
        <div class="ressource-card"
             data-category="{{Str::lower( $ressource->categorie->nom ?? 'autre' )}}"
             data-status="{{ $ressource->statut ?? 'disponible' }}">
            <div class="ressource-header">
                <div class="ressource-icon">
                    {{-- You can customize icon based on category if you want --}}
                    🖥️
                </div>
                <h3>{{ $ressource->nom }}</h3>
                <p class="ressource-category">
                    {{ $ressource->type ?? ($ressource->categorie->nom ?? 'Ressource') }}
                </p>
            </div>

            <div class="ressource-body">
                <div class="ressource-info">
                    <div class="info-item">
                        <span class="info-label">CPU</span>
                        <span class="info-value">{{ $ressource->cpu ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">RAM</span>
                        <span class="info-value">{{ $ressource->ram ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Stockage</span>
                        <span class="info-value">{{ $ressource->stockage ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Statut</span>
                        <span class="status-badge
                            @if(($ressource->statut ?? '') === 'disponible') status-available
                            @elseif(($ressource->statut ?? '') === 'maintenance') status-maintenance
                            @else status-busy @endif">
                            {{ ucfirst($ressource->statut ?? 'disponible') }}
                        </span>
                    </div>
                </div>

                <a href="{{ route('ressources.show', $ressource) }}" class="btn-details">
                    Voir détails
                </a>
            </div>
        </div>
    @endforeach
</div>
    

<script>
function filterRessources() {
    const category = document.getElementById('categoryFilter').value.toLowerCase();
    const status   = document.getElementById('statusFilter').value.toLowerCase();
    const search   = document.getElementById('searchInput').value.toLowerCase();
    const cards    = document.querySelectorAll('.ressource-card');

    cards.forEach(card => {
        const cardCategory = (card.getAttribute('data-category') || '').toLowerCase();
        const cardStatus   = (card.getAttribute('data-status') || '').toLowerCase();
        const title        = card.querySelector('.ressource-header h3').textContent.toLowerCase();
        const categoryText = card.querySelector('.ressource-category').textContent.toLowerCase();
        const cardText     = title + ' ' + categoryText;

        const matchCategory = !category || cardCategory === category;
        const matchStatus   = !status || cardStatus === status;
        const matchSearch   = !search || cardText.includes(search);

        card.style.display = (matchCategory && matchStatus && matchSearch)
            ? 'block'
            : 'none';
    });
}

// Filtres sur changement de select
document.getElementById('categoryFilter').addEventListener('change', filterRessources);
document.getElementById('statusFilter').addEventListener('change', filterRessources);
// Recherche instantanée
document.getElementById('searchInput').addEventListener('input', filterRessources);
</script>

@endsection