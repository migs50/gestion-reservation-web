@extends('layouts.app')

@section('title', 'Ressources disponibles')

@section('content')
<style>
    .page-header {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .page-header h1 {
        font-size: 32px;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .page-header p {
        color: #7f8c8d;
        font-size: 16px;
    }

    .filters {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .filters h3 {
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .filter-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .filter-group select,
    .filter-group input {
        padding: 12px;
        border: 2px solid #ecf0f1;
        border-radius: 8px;
        font-size: 14px;
    }

    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: #667eea;
    }

    .btn-filter {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .ressources-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
    }

    .ressource-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .ressource-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .ressource-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px;
        color: white;
        text-align: center;
    }

    .ressource-icon {
        font-size: 48px;
        margin-bottom: 10px;
    }

    .ressource-header h3 {
        font-size: 20px;
        margin-bottom: 5px;
    }

    .ressource-category {
        font-size: 13px;
        opacity: 0.9;
    }

    .ressource-body {
        padding: 20px;
    }

    .ressource-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 6px;
    }

    .info-label {
        color: #7f8c8d;
        font-size: 14px;
    }

    .info-value {
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-available {
        background: #d4edda;
        color: #155724;
    }

    .status-busy {
        background: #fff3cd;
        color: #856404;
    }

    .status-maintenance {
        background: #f8d7da;
        color: #721c24;
    }

    .btn-details {
        display: block;
        width: 100%;
        padding: 12px;
        background: #667eea;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: background 0.3s ease;
    }

    .btn-details:hover {
        background: #5568d3;
    }
</style>

<div class="page-header">
    <h1>📦 Ressources disponibles</h1>
    <p>Découvrez toutes les ressources informatiques de notre Data Center</p>
</div>

<!-- Filters -->
<div class="filters">
    <h3>🔍 Filtrer les ressources</h3>
    <div class="filter-group">
        <select id="categoryFilter">
            <option value="">Toutes les catégories</option>
            <option value="serveur">Serveurs</option>
            <option value="vm">Machines Virtuelles</option>
            <option value="stockage">Stockage</option>
            <option value="reseau">Réseau</option>
        </select>

        <select id="statusFilter">
            <option value="">Tous les statuts</option>
            <option value="disponible">Disponible</option>
            <option value="occupe">Occupé</option>
            <option value="maintenance">Maintenance</option>
        </select>

        <input type="text" id="searchInput" placeholder="Rechercher une ressource...">

        <button class="btn-filter" onclick="filterRessources()">Filtrer</button>
    </div>
</div>

<!-- Ressources Grid -->

{{-- @foreach ($ressources as $ressource) ADD THIS AFTER THE RESSOURCE CREATION FUNCTIONALITIES ARE SET AND CHANGE THE STATIC IDS(1,2,3) TO $ressource->id --}}
<div class="ressources-grid" id="ressourcesGrid">
 {{-- @foreach ($ressources as $ressource) HERE AND END IT AT THE END OF RESSOURCES --}}
    <!-- Serveur 1 -->
    <div class="ressource-card" data-category="serveur" data-status="disponible">
        <div class="ressource-header">
            <div class="ressource-icon">🖥️</div>
            <h3>Serveur Dell PowerEdge R740</h3>
            <p class="ressource-category">Serveur Physique</p>
        </div>
        <div class="ressource-body">
            <div class="ressource-info">
                <div class="info-item">
                    <span class="info-label">CPU</span>
                    <span class="info-value">Intel Xeon Gold 6248R</span>
                </div>
                <div class="info-item">
                    <span class="info-label">RAM</span>
                    <span class="info-value">256 GB DDR4</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Stockage</span>
                    <span class="info-value">2 TB NVMe SSD</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Statut</span>
                    <span class="status-badge status-available">Disponible</span>
                </div>
            </div>
            <a href="{{ route('ressources.show', 1) }}" class="btn-details">Voir détails</a>

        </div>
    </div>

    <!-- VM 1 -->
    <div class="ressource-card" data-category="vm" data-status="disponible">
        <div class="ressource-header">
            <div class="ressource-icon">💻</div>
            <h3>VM Ubuntu 22.04 LTS</h3>
            <p class="ressource-category">Machine Virtuelle</p>
        </div>
        <div class="ressource-body">
            <div class="ressource-info">
                <div class="info-item">
                    <span class="info-label">vCPU</span>
                    <span class="info-value">8 Cores</span>
                </div>
                <div class="info-item">
                    <span class="info-label">RAM</span>
                    <span class="info-value">32 GB</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Stockage</span>
                    <span class="info-value">500 GB SSD</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Statut</span>
                    <span class="status-badge status-available">Disponible</span>
                </div>
            </div>
            <a href="{{ route('ressources.show', 2) }}" class="btn-details">Voir détails</a>
        </div>
    </div>

    <!-- Stockage 1 -->
    <div class="ressource-card" data-category="stockage" data-status="occupe">
        <div class="ressource-header">
            <div class="ressource-icon">💾</div>
            <h3>Baie de stockage NetApp</h3>
            <p class="ressource-category">Stockage</p>
        </div>
        <div class="ressource-body">
            <div class="ressource-info">
                <div class="info-item">
                    <span class="info-label">Capacité totale</span>
                    <span class="info-value">50 TB</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Disponible</span>
                    <span class="info-value">15 TB</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Type</span>
                    <span class="info-value">SAN / NAS</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Statut</span>
                    <span class="status-badge status-busy">Occupé</span>
                </div>
            </div>
            <a href="{{ route('ressources.show', 3) }}" class="btn-details">Voir détails</a>
        </div>
    </div>

    <!-- Réseau 1 -->
    <div class="ressource-card" data-category="reseau" data-status="disponible">
        <div class="ressource-header">
            <div class="ressource-icon">🌐</div>
            <h3>Switch Cisco Catalyst 9300</h3>
            <p class="ressource-category">Équipement Réseau</p>
        </div>
        <div class="ressource-body">
            <div class="ressource-info">
                <div class="info-item">
                    <span class="info-label">Ports</span>
                    <span class="info-value">48 x 1G/10G</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Uplinks</span>
                    <span class="info-value">4 x 40G QSFP+</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Débit</span>
                    <span class="info-value">440 Gbps</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Statut</span>
                    <span class="status-badge status-available">Disponible</span>
                </div>
            </div>
            <a href="{{ route('ressources.show', 4) }}" class="btn-details">Voir détails</a>
        </div>
    </div>

    <!-- Serveur 2 -->
    <div class="ressource-card" data-category="serveur" data-status="maintenance">
        <div class="ressource-header">
            <div class="ressource-icon">🖥️</div>
            <h3>Serveur HPE ProLiant DL380</h3>
            <p class="ressource-category">Serveur Physique</p>
        </div>
        <div class="ressource-body">
            <div class="ressource-info">
                <div class="info-item">
                    <span class="info-label">CPU</span>
                    <span class="info-value">Intel Xeon Silver 4214</span>
                </div>
                <div class="info-item">
                    <span class="info-label">RAM</span>
                    <span class="info-value">128 GB DDR4</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Stockage</span>
                    <span class="info-value">4 TB HDD RAID5</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Statut</span>
                    <span class="status-badge status-maintenance">Maintenance</span>
                </div>
            </div>
            <a href="{{ route('ressources.show', 5) }}" class="btn-details">Voir détails</a>
        </div>
    </div>

    <!-- VM 2 -->
    <div class="ressource-card" data-category="vm" data-status="disponible">
        <div class="ressource-header">
            <div class="ressource-icon">💻</div>
            <h3>VM Windows Server 2022</h3>
            <p class="ressource-category">Machine Virtuelle</p>
        </div>
        <div class="ressource-body">
            <div class="ressource-info">
                <div class="info-item">
                    <span class="info-label">vCPU</span>
                    <span class="info-value">4 Cores</span>
                </div>
                <div class="info-item">
                    <span class="info-label">RAM</span>
                    <span class="info-value">16 GB</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Stockage</span>
                    <span class="info-value">250 GB SSD</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Statut</span>
                    <span class="status-badge status-available">Disponible</span>
                </div>
            </div>
            <a href="{{ route('ressources.show', 6) }}" class="btn-details">Voir détails</a>
        </div>
    </div>
</div>

<script>
    // Filter resources
    function filterRessources() {
        const category = document.getElementById('categoryFilter').value;
        const status = document.getElementById('statusFilter').value;
        const search = document.getElementById('searchInput').value.toLowerCase();
        const cards = document.querySelectorAll('.ressource-card');

        cards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            const cardStatus = card.getAttribute('data-status');
            const cardText = card.textContent.toLowerCase();

            const matchCategory = !category || cardCategory === category;
            const matchStatus = !status || cardStatus === status;
            const matchSearch = !search || cardText.includes(search);

            if (matchCategory && matchStatus && matchSearch) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Filter on input change
    document.getElementById('searchInput').addEventListener('input', filterRessources);
</script>
@endsection