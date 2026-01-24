@extends('layouts.app')

@section('title', 'Mon Tableau de Bord')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    .dashboard-header {
        background-color: #383a59;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        color: white; /* Text color for the whole block */
    }

    .welcome-text h1 {
        font-size: 28px;
        color: white; /* White text */
        margin-bottom: 10px;
    }

    .welcome-text p {
        color: rgba(255, 255, 255, 0.8); /* Slightly faded white */
        font-size: 16px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .stat-icon.blue { background: rgba(102, 126, 234, 0.1); }
    .stat-icon.green { background: rgba(46, 204, 113, 0.1); }
    .stat-icon.orange { background: rgba(230, 126, 34, 0.1); }
    .stat-icon.purple { background: rgba(155, 89, 182, 0.1); }

    .stat-details h3 {
        font-size: 32px;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .stat-details p {
        color: #7f8c8d;
        font-size: 14px;
    }

    .quick-actions {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .quick-actions h2 {
        font-size: 20px;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px 20px;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        text-decoration: none;
        color: #2c3e50;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        background: linear-gradient(135deg, #323361b3 0%, #484980ff 100%);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }

    .action-btn span {
        font-size: 24px;
    }

    .recent-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .recent-section h2 {
        font-size: 20px;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .reservation-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #ecf0f1;
    }

    .reservation-item:last-child {
        border-bottom: none;
    }

    .reservation-info h4 {
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .reservation-info p {
        color: #7f8c8d;
        font-size: 13px;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-warning { background: #fff3cd; color: #856404; }
    .badge-success { background: #d4edda; color: #155724; }
    .badge-danger { background: #f8d7da; color: #721c24; }
    .badge-info { background: #d1ecf1; color: #0c5460; }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #7f8c8d;
    }

    .empty-state span {
        font-size: 48px;
        display: block;
        margin-bottom: 15px;
    }
</style>

<!-- Header -->
<div class="dashboard-header">
    <div class="welcome-text">
        <h1> Bonjour, {{ Auth::user()->nom }} {{ Auth::user()->prenom }}</h1>
        <p>Bienvenue sur votre tableau de bord personnel</p>
    </div>
</div>

<!-- Statistics -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-details">
            <h3>{{ $stats['total'] ?? 0 }}</h3>
            <p style="color: #667787ff; font-size: 24px;">Réservations totales</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-details">
            <h3>{{ $stats['actives'] ?? 0 }}</h3>
            <p style="color: #667787ff; font-size: 24px;">Réservations actives</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-details">
            <h3>{{ $stats['en_attente'] ?? 0 }}</h3>
            <p style="color: #667787ff; font-size: 24px;">En attente</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <h2> Actions rapides</h2>
    <div class="actions-grid">
        <a href="{{ route('catalogue') }}" class="action-btn">
            <span></span>
            <div>Nouvelle réservation</div>
        </a>

        <a href="{{ route('reservations.index') }}" class="action-btn">
            <span></span>
            <div>Mes réservations</div>
        </a>
{{-- TEMPRORY COMMENT FOR WHEN ITS ADDED!!!! --}}
        {{-- <a href="{{ route('user.incident.report') }}" class="action-btn">
            <span></span>
            <div>Signaler un incident</div>
        </a> --}}
    </div>
</div>

<!-- Recent Reservations -->
<div class="recent-section">
    <h2>📌 Réservations récentes</h2>
    
    @if(!empty($recent_reservations) && $recent_reservations->count() > 0)
        @foreach($recent_reservations as $reservation)
        <div class="reservation-item">
            <div class="reservation-info">
                <h4>{{ $reservation->ressource->nom }}</h4>
                <p>
                    Du {{ $reservation->debut->format('d/m/Y H:i') }} 
                    au {{ $reservation->fin->format('d/m/Y H:i') }}
                </p>
            </div>
            <div>
                @if($reservation->statut == 'pending')
                    <span class="badge badge-warning">En attente</span>
                @elseif($reservation->statut == 'approved')
                    <span class="badge badge-success">Approuvée</span>
                @elseif($reservation->statut == 'refused')
                    <span class="badge badge-danger">Refusée</span>
                @elseif($reservation->statut == 'active')
                    <span class="badge badge-info">Active</span>
                @endif
            </div>
        </div>
        @endforeach
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('reservations.index') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">
                Voir toutes les réservations →
            </a>
        </div>
    @else
        <div class="empty-state">
            <span>📭</span>
            <p>Aucune réservation récente</p>
            <a href="{{ route('catalogue') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">
                Créer votre première réservation
            </a>
        </div>
    @endif
</div>

<div class="recent-section" style="margin-top: 30px;">
    <h2>📈 Activité des 7 derniers jours</h2>
    <div style="height: 300px; position: relative;">
        <canvas id="userActivityChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('userActivityChart').getContext('2d');
    const activityData = @json($activity_data);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: activityData.labels,
            datasets: [{
                label: 'Réservations',
                data: activityData.values,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#764ba2',
                pointBorderColor: '#fff',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#94a3b8' },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    ticks: { color: '#94a3b8' },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>

@if(session('success'))
<script>
    alert('✅ {{ session('success') }}');
</script>
@endif
@endsection