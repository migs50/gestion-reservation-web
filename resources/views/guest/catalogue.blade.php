@extends('layouts.guest')

@section('title', 'Catalogue des Ressources - Data Center')

@section('content')
    <div class="container">
        <h1 class="section-title mt-4">Catalogue des Ressources</h1>
        <p class="section-subtitle">Explorez les ressources disponibles dans notre Data Center</p>

        <!-- Info Notice -->
        <div class="login-notice">
            <div class="login-notice-icon">ℹ️</div>
            <div class="login-notice-content">
                <div class="login-notice-title">Mode consultation</div>
                <div class="login-notice-text">
                    Vous consultez le catalogue en mode lecture seule. 
                    Pour effectuer des réservations, 
                    <a href="{{ route('demande.compte') }}" style="color: #1e40af; font-weight: bold;">déposez une demande de compte</a>.
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" class="search-input" id="searchInput" placeholder="🔍 Rechercher une ressource par nom, type ou caractéristique...">
        </div>

        <!-- Category Tabs -->
        <div class="category-tabs">
            <button class="tab-button active" data-category="all">Toutes les ressources</button>
            <button class="tab-button" data-category="serveur">Serveurs Physiques</button>
            <button class="tab-button" data-category="vm">Machines Virtuelles</button>
            <button class="tab-button" data-category="stockage">Stockage</button>
            <button class="tab-button" data-category="reseau">Équipements Réseau</button>
        </div>

        <!-- Resources Grid -->
        <div class="resource-grid" id="resourceGrid">
            @foreach($ressources as $ressource)
                <div class="resource-card" data-category="{{ $ressource->categorie }}">
                    <div class="resource-header">
                        <div>
                            <div class="resource-title">{{ $ressource->nom }}</div>
                            <div class="resource-type">{{ $ressource->type }}</div>
                        </div>
                        <div style="font-size: 2rem;">{{ $ressource->icone }}</div>
                    </div>
                    <div class="resource-body">
                        <div class="resource-specs">
                            @foreach($ressource->specifications as $label => $value)
                                <div class="spec-item">
                                    <span class="spec-label">{{ $label }}:</span>
                                    <span class="spec-value">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="resource-status">
                            <div class="status-indicator">
                                <span class="status-dot {{ $ressource->statut }}"></span>
                                <span style="font-weight: 600; color: {{ $ressource->couleur_statut }};">{{ $ressource->texte_statut }}</span>
                            </div>
                            <span class="badge badge-{{ $ressource->badge_type }}">{{ $ressource->badge_texte }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="empty-state" id="emptyState" style="display: none;">
            <div class="empty-state-icon">🔍</div>
            <h3>Aucune ressource trouvée</h3>
            <p>Essayez de modifier vos critères de recherche ou de sélectionner une autre catégorie.</p>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Styles spécifiques au catalogue */
    .resource-grid { /* ... */ }
    .resource-card { /* ... */ }
    /* Copiez les styles du catalogue.html */
</style>
@endpush

@push('scripts')
<script>
    // JavaScript pour le filtrage et la recherche
    const tabButtons = document.querySelectorAll('.tab-button');
    const resourceCards = document.querySelectorAll('.resource-card');
    const searchInput = document.getElementById('searchInput');
    const resourceGrid = document.getElementById('resourceGrid');
    const emptyState = document.getElementById('emptyState');

    let currentCategory = 'all';
    let searchTerm = '';

    function filterResources() {
        let visibleCount = 0;

        resourceCards.forEach(card => {
            const category = card.dataset.category;
            const text = card.textContent.toLowerCase();
            
            const categoryMatch = currentCategory === 'all' || category === currentCategory;
            const searchMatch = text.includes(searchTerm.toLowerCase());

            if (categoryMatch && searchMatch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            resourceGrid.style.display = 'none';
            emptyState.style.display = 'block';
        } else {
            resourceGrid.style.display = 'grid';
            emptyState.style.display = 'none';
        }
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            currentCategory = button.dataset.category;
            filterResources();
        });
    });

    searchInput.addEventListener('input', (e) => {
        searchTerm = e.target.value;
        filterResources();
    });
</script>
@endpush