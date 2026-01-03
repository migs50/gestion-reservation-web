@extends('layouts.app')

@section('title', 'Historique des Réservations')

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
        font-size: 28px;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .page-header p {
        color: #7f8c8d;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        text-align: center;
    }

    .stat-value {
        font-size: 36px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 10px;
    }

    .stat-label {
        color: #7f8c8d;
        font-size: 14px;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .chart-card h3 {
        font-size: 18px;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .bar-chart {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        height: 250px;
        gap: 10px;
        padding: 20px 0;
    }

    .bar {
        flex: 1;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px 8px 0 0;
        position: relative;
        transition: all 0.3s ease;
        min-height: 20px;
    }

    .bar:hover {
        opacity: 0.8;
        transform: translateY(-5px);
    }

    .bar-label {
        position: absolute;
        bottom: -25px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 12px;
        color: #6c757d;
        white-space: nowrap;
    }

    .bar-value {
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
    }

    .pie-chart {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 250px;
        position: relative;
    }

    .pie-slice {
        position: absolute;
    }

    .pie-legend {
        display: grid;
        gap: 10px;
        margin-top: 20px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
    }

    .legend-label {
        flex: 1;
        color: #555;
    }

    .legend-value {
        font-weight: 600;
        color: #2c3e50;
    }

    .filters-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .filters-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        align-items: end;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #2c3e50;
        font-weight: 500;
        font-size: 14px;
    }

    .form-group select,
    .form-group input {
        width: 100%;
        padding: 10px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
    }

    .form-group select:focus,
    .form-group input:focus {
        outline: none;
        border-color: #667eea;
    }

    .btn-filter {
        padding: 10px 20px;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-filter:hover {
        background: #5568d3;
    }

    .history-table {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead {
        background: #f8f9fa;
    }

    .table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
    }

    .table td {
        padding: 15px;
        border-top: 1px solid #ecf0f1;
        color: #555;
        font-size: 14px;
    }

    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success { background: #d4edda; color: #155724; }
    .badge-danger { background: #f8d7da; color: #721c24; }
    .badge-warning { background: #fff3cd; color: #856404; }
    .badge-info { background: #d1ecf1; color: #0c5460; }
    .badge-secondary { background: #e2e3e5; color: #383d41; }

    .btn-sm {
        padding: 6px 12px;
        background: #667eea;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }

    .btn-sm:hover {
        background: #5568d3;
    }

    .pagination {
        padding: 25px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 992px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }
</style>

<!-- Header -->
<div class="page-header">
    <h1>📊 Historique des Réservations</h1>
    <p>Consultez toutes vos réservations passées et leurs statistiques</p>
</div>

<!-- Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
        <div class="stat-label">Total de réservations</div>
    </div>

    <div class="stat-card">
        <div class="stat-value">{{ $stats['approuvees'] ?? 0 }}</div>
        <div class="stat-label">Réservations approuvées</div>
    </div>

    <div class="stat-card">
        <div class="stat-value">{{ $stats['refusees'] ?? 0 }}</div>
        <div class="stat-label">Réservations refusées</div>
    </div>

    <div class="stat-card">
        <div class="stat-value">{{ $stats['heures_totales'] ?? 0 }}h</div>
        <div class="stat-label">Heures d'utilisation</div>
    </div>

    <div class="stat-card">
        <div class="stat-value">{{ $stats['taux_approbation'] ?? 0 }}%</div>
        <div class="stat-label">Taux d'approbation</div>
    </div>
</div>

<!-- Charts -->
<div class="charts-grid">
    <!-- Monthly Bar Chart -->
    <div class="chart-card">
        <h3>📈 Réservations par mois</h3>
        <div class="chart-container">
            <div class="bar-chart">
                @foreach($monthly_stats ?? [] as $month => $count)
                <div class="bar" style="height: {{ ($count / max(array_values($monthly_stats ?? [1]))) * 100 }}%;">
                    <span class="bar-value">{{ $count }}</span>
                    <span class="bar-label">{{ $month }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Status Distribution -->
    <div class="chart-card">
        <h3>📊 Répartition par statut</h3>
        <div style="display: flex; justify-content: center; align-items: center; height: 200px; gap: 20px;">
            @php
                $colors = [
                    'approuvee' => '#2ecc71',
                    'refusee' => '#e74c3c',
                    'terminee' => '#95a5a6',
                    'annulee' => '#e67e22'
                ];
                $labels = [
                    'approuvee' => 'Approuvées',
                    'refusee' => 'Refusées',
                    'terminee' => 'Terminées',
                    'annulee' => 'Annulées'
                ];
            @endphp
            @foreach($status_distribution ?? [] as $status => $count)
            <div style="text-align: center;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: {{ $colors[$status] ?? '#95a5a6' }}; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; font-weight: bold; margin: 0 auto 10px;">
                    {{ $count }}
                </div>
                <div style="font-size: 13px; color: #555;">{{ $labels[$status] ?? ucfirst($status) }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Resource Types -->
    <div class="chart-card">
        <h3>🖥️ Ressources les plus utilisées</h3>
        <div class="pie-legend">
            @foreach($top_ressources ?? [] as $ressource)
            <div class="legend-item">
                <div class="legend-color" style="background: {{ sprintf('#%06X', mt_rand(0, 0xFFFFFF)) }};"></div>
                <span class="legend-label">{{ $ressource->nom }}</span>
                <span class="legend-value">{{ $ressource->count }} fois</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Duration Chart -->
    <div class="chart-card">
        <h3>⏱️ Durée moyenne par catégorie</h3>
        <div class="pie-legend">
            @foreach($avg_duration_by_category ?? [] as $category => $hours)
            <div class="legend-item">
                <div class="legend-color" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                <span class="legend-label">{{ $category }}</span>
                <span class="legend-value">{{ number_format($hours, 1) }}h</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Filters -->
<div class="filters-card">
    <form action="{{ route('user.history') }}" method="GET" class="filters-form">
        <div class="form-group">
            <label>Statut</label>
            <select name="statut">
                <option value="">Tous les statuts</option>
                <option value="approuvee" {{ request('statut') == 'approuvee' ? 'selected' : '' }}>Approuvées</option>
                <option value="refusee" {{ request('statut') == 'refusee' ? 'selected' : '' }}>Refusées</option>
                <option value="terminee" {{ request('statut') == 'terminee' ? 'selected' : '' }}>Terminées</option>
                <option value="annulee" {{ request('statut') == 'annulee' ? 'selected' : '' }}>Annulées</option>
            </select>
        </div>

        <div class="form-group">
            <label>Période début</label>
            <input type="date" name="date_debut" value="{{ request('date_debut') }}">
        </div>

        <div class="form-group">
            <label>Période fin</label>
            <input type="date" name="date_fin" value="{{ request('date_fin') }}">
        </div>

        <div class="form-group">
            <label>Ressource</label>
            <select name="ressource_id">
                <option value="">Toutes les ressources</option>
                @foreach($ressources ?? [] as $ressource)
                    <option value="{{ $ressource->id }}" {{ request('ressource_id') == $ressource->id ? 'selected' : '' }}>
                        {{ $ressource->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-filter">🔍 Filtrer</button>
        </div>
    </form>
</div>

<!-- History Table -->
<div class="history-table">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Ressource</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Durée</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations ?? [] as $reservation)
                <tr>
                    <td><strong>#{{ $reservation->id }}</strong></td>
                    <td>
                        <div style="font-weight: 600;">{{ $reservation->ressource->nom }}</div>
                        <div style="font-size: 12px; color: #7f8c8d;">{{ $reservation->ressource->categorie->nom ?? '-' }}</div>
                    </td>
                    <td>{{ $reservation->date_debut->format('d/m/Y H:i') }}</td>
                    <td>{{ $reservation->date_fin->format('d/m/Y H:i') }}</td>
                    <td>{{ $reservation->date_debut->diffInDays($reservation->date_fin) }}j</td>
                    <td>
                        @switch($reservation->statut)
                            @case('approuvee')
                                <span class="badge badge-success">✅ Approuvée</span>
                                @break
                            @case('refusee')
                                <span class="badge badge-danger">❌ Refusée</span>
                                @break
                            @case('terminee')
                                <span class="badge badge-secondary">✓ Terminée</span>
                                @break
                            @case('annulee')
                                <span class="badge badge-warning">⊘ Annulée</span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        <a href="{{ route('user.reservation.show', $reservation->id) }}" class="btn-sm">
                            👁️ Détails
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #7f8c8d;">
                        📭 Aucun historique de réservation
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($reservations) && $reservations->hasPages())
    <div class="pagination">
        {{ $reservations->links() }}
    </div>
    @endif
</div>
@endsection
