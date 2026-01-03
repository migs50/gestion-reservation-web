{{-- 
    📄 Fichier : statistics.blade.php
    📁 Chemin : resources/views/admin/statistics.blade.php
    🎯 Rôle : Admin (statistiques avancées)
    📝 Description : Tableau de bord statistiques avec graphiques dynamiques
--}}

@extends('layouts.admin')

@section('title', 'Statistiques Avancées')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .filters {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .stat-card h3 {
        font-size: 36px;
        color: #2c3e50;
        margin-bottom: 5px;
        font-weight: 800;
    }
    .stat-card p {
        color: #7f8c8d;
        font-size: 14px;
        margin: 0;
    }
    .stat-change {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 10px;
    }
    .stat-change.up {
        background: #d4edda;
        color: #155724;
    }
    .stat-change.down {
        background: #f8d7da;
        color: #721c24;
    }
    .chart-container {
        background: white;
        padding: 25px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .chart-container h3 {
        margin-bottom: 20px;
        color: #2c3e50;
    }
    .chart-wrapper {
        position: relative;
        height: 350px;
    }
    .grid-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }
    .top-items {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .top-items li {
        padding: 12px;
        background: #f8f9fa;
        margin-bottom: 8px;
        border-radius: 6px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .top-items li:hover {
        background: #e9ecef;
    }
    .badge-rank {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 12px;
    }
    @media (max-width: 768px) {
        .grid-2col {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h2>📊 Statistiques Avancées</h2>
    <button onclick="exportStatistics()" class="btn btn-primary">📥 Exporter PDF</button>
</div>

<!-- Filtres de période -->
<form method="GET" action="{{ route('admin.statistics') }}" class="filters">
    <select name="periode" id="periodeFilter" onchange="this.form.submit()">
        <option value="7" {{ request('periode', 7) == 7 ? 'selected' : '' }}>7 derniers jours</option>
        <option value="30" {{ request('periode') == 30 ? 'selected' : '' }}>30 derniers jours</option>
        <option value="90" {{ request('periode') == 90 ? 'selected' : '' }}>90 derniers jours</option>
        <option value="365" {{ request('periode') == 365 ? 'selected' : '' }}>Année complète</option>
    </select>
    
    <input type="date" name="date_debut" value="{{ request('date_debut') }}" class="form-control">
    <input type="date" name="date_fin" value="{{ request('date_fin') }}" class="form-control">
    
    <button type="submit" class="btn">🔍 Filtrer</button>
    <button type="button" class="btn btn-secondary" onclick="resetFilters()">🔄 Réinitialiser</button>
</form>

<!-- Statistiques principales -->
<div class="stats-grid">
    <div class="stat-card">
        <h3 id="totalReservations">{{ $stats['total_reservations'] }}</h3>
        <p>📋 Réservations totales</p>
        <span class="stat-change {{ $stats['reservations_change'] >= 0 ? 'up' : 'down' }}">
            {{ $stats['reservations_change'] >= 0 ? '↑' : '↓' }} {{ abs($stats['reservations_change']) }}% vs période précédente
        </span>
    </div>

    <div class="stat-card">
        <h3 id="tauxOccupation">{{ $stats['taux_occupation'] }}%</h3>
        <p>📊 Taux d'occupation moyen</p>
        <span class="stat-change {{ $stats['occupation_change'] >= 0 ? 'up' : 'down' }}">
            {{ $stats['occupation_change'] >= 0 ? '↑' : '↓' }} {{ abs($stats['occupation_change']) }}% vs période précédente
        </span>
    </div>

    <div class="stat-card">
        <h3 id="dureeeMoyenne">{{ $stats['duree_moyenne'] }}j</h3>
        <p>⏱️ Durée moyenne réservation</p>
        <span class="stat-change {{ $stats['duree_change'] >= 0 ? 'up' : 'down' }}">
            {{ $stats['duree_change'] >= 0 ? '↑' : '↓' }} {{ abs($stats['duree_change']) }}% vs période précédente
        </span>
    </div>

    <div class="stat-card">
        <h3 id="tauxApprobation">{{ $stats['taux_approbation'] }}%</h3>
        <p>✅ Taux d'approbation</p>
        <span class="stat-change {{ $stats['approbation_change'] >= 0 ? 'up' : 'down' }}">
            {{ $stats['approbation_change'] >= 0 ? '↑' : '↓' }} {{ abs($stats['approbation_change']) }}% vs période précédente
        </span>
    </div>
</div>

<!-- Graphiques principaux -->
<div class="grid-2col">
    <!-- Évolution des réservations -->
    <div class="chart-container">
        <h3>📈 Évolution des réservations</h3>
        <div class="chart-wrapper">
            <canvas id="reservationsChart"></canvas>
        </div>
    </div>

    <!-- Répartition par statut -->
    <div class="chart-container">
        <h3>🎯 Répartition par statut</h3>
        <div class="chart-wrapper">
            <canvas id="statutChart"></canvas>
        </div>
    </div>
</div>

<!-- Répartition par catégorie -->
<div class="chart-container">
    <h3>📊 Réservations par catégorie de ressource</h3>
    <div class="chart-wrapper" style="height: 300px;">
        <canvas id="categoriesChart"></canvas>
    </div>
</div>

<!-- Top utilisateurs et ressources -->
<div class="grid-2col">
    <div class="chart-container">
        <h3>🏆 Top 10 Utilisateurs</h3>
        <ul class="top-items">
            @foreach($top_users as $index => $user)
            <li>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span class="badge-rank">{{ $index + 1 }}</span>
                    <div>
                        <strong>{{ $user->nom }} {{ $user->prenom }}</strong>
                        <br>
                        <small style="color: #7f8c8d;">{{ $user->email }}</small>
                    </div>
                </div>
                <strong style="color: #667eea;">{{ $user->reservations_count }} réservations</strong>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="chart-container">
        <h3>💾 Top 10 Ressources</h3>
        <ul class="top-items">
            @foreach($top_ressources as $index => $ressource)
            <li>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span class="badge-rank">{{ $index + 1 }}</span>
                    <div>
                        <strong>{{ $ressource->nom }}</strong>
                        <br>
                        <small style="color: #7f8c8d;">{{ $ressource->categorie->nom ?? 'N/A' }}</small>
                    </div>
                </div>
                <strong style="color: #667eea;">{{ $ressource->reservations_count }} réservations</strong>
            </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Statistiques détaillées -->
<div class="chart-container">
    <h3>📋 Détails statistiques</h3>
    <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
        <div style="padding: 15px; background: #f8f9fa; border-radius: 6px;">
            <strong style="display: block; margin-bottom: 8px;">Total demandes</strong>
            <span style="font-size: 24px; font-weight: 700; color: #667eea;">{{ $stats['total_demandes'] }}</span>
        </div>
        <div style="padding: 15px; background: #f8f9fa; border-radius: 6px;">
            <strong style="display: block; margin-bottom: 8px;">Approuvées</strong>
            <span style="font-size: 24px; font-weight: 700; color: #48bb78;">{{ $stats['approuvees'] }}</span>
        </div>
        <div style="padding: 15px; background: #f8f9fa; border-radius: 6px;">
            <strong style="display: block; margin-bottom: 8px;">Refusées</strong>
            <span style="font-size: 24px; font-weight: 700; color: #e74c3c;">{{ $stats['refusees'] }}</span>
        </div>
        <div style="padding: 15px; background: #f8f9fa; border-radius: 6px;">
            <strong style="display: block; margin-bottom: 8px;">En attente</strong>
            <span style="font-size: 24px; font-weight: 700; color: #f39c12;">{{ $stats['en_attente'] }}</span>
        </div>
        <div style="padding: 15px; background: #f8f9fa; border-radius: 6px;">
            <strong style="display: block; margin-bottom: 8px;">Ressources actives</strong>
            <span style="font-size: 24px; font-weight: 700; color: #667eea;">{{ $stats['ressources_actives'] }}</span>
        </div>
        <div style="padding: 15px; background: #f8f9fa; border-radius: 6px;">
            <strong style="display: block; margin-bottom: 8px;">Utilisateurs actifs</strong>
            <span style="font-size: 24px; font-weight: 700; color: #667eea;">{{ $stats['utilisateurs_actifs'] }}</span>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Données depuis backend
const evolutionData = @json($evolution_data);
const statutData = @json($statut_data);
const categoriesData = @json($categories_data);

// Graphique évolution
const ctxEvolution = document.getElementById('reservationsChart').getContext('2d');
new Chart(ctxEvolution, {
    type: 'line',
    data: {
        labels: evolutionData.labels,
        datasets: [{
            label: 'Réservations',
            data: evolutionData.values,
            borderColor: '#667eea',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        }
    }
});

// Graphique statuts (donut)
const ctxStatut = document.getElementById('statutChart').getContext('2d');
new Chart(ctxStatut, {
    type: 'doughnut',
    data: {
        labels: statutData.labels,
        datasets: [{
            data: statutData.values,
            backgroundColor: ['#48bb78', '#f39c12', '#e74c3c', '#95a5a6']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Graphique catégories (bar)
const ctxCategories = document.getElementById('categoriesChart').getContext('2d');
new Chart(ctxCategories, {
    type: 'bar',
    data: {
        labels: categoriesData.labels,
        datasets: [{
            label: 'Réservations',
            data: categoriesData.values,
            backgroundColor: '#764ba2'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        }
    }
});

function resetFilters() {
    window.location.href = '{{ route("admin.statistics") }}';
}

function exportStatistics() {
    alert('Export PDF en cours de développement...');
    // TODO: Implémenter export PDF
}

// Animation des compteurs
document.addEventListener('DOMContentLoaded', function() {
    animateCounters();
});

function animateCounters() {
    const counters = [
        { id: 'totalReservations', target: {{ $stats['total_reservations'] }} },
        { id: 'tauxOccupation', target: {{ $stats['taux_occupation'] }} },
        { id: 'dureeeMoyenne', target: {{ $stats['duree_moyenne'] }} },
        { id: 'tauxApprobation', target: {{ $stats['taux_approbation'] }} }
    ];

    counters.forEach(counter => {
        const element = document.getElementById(counter.id);
        let current = 0;
        const increment = counter.target / 50;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= counter.target) {
                element.textContent = counter.target + (counter.id.includes('taux') || counter.id.includes('Occupation') ? '%' : counter.id.includes('Moyenne') ? 'j' : '');
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 20);
    });
}
</script>
@endsection