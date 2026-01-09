@extends('layouts.admin')

@section('title', 'Dashboard Administrateur')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    //*.stat-card h3 {
        font-size: 32px;
        color: #2c3e50;
        margin-bottom: 10px;
        align-self: auto;
    }*//
      .stats-row {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }
    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: 1fr;
        }
    }
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin: 30px 0;
    }
    .action-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        color: #2c3e50;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .action-card:hover {
        transform: translateY(-3px);
    }
    .chart-container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
</style>

<!-- Statistiques -->
<div class="stats-row">
    <div class="stat-card">
        <a href="{{ route('dashboard.user') }}" style="text-decoration:none; color:inherit;">
        <h3 id="totalUsers">{{ $stats['total_users'] ?? 0 }}</h3>
        <p>👥 Utilisateurs</p>
    </div>
    <a href="{{ route('publique.ressources') }}"style="text-decoration:none; color:inherit;">
    <div class="stat-card">
        <h3 id="totalRessources">{{ $stats['total_ressources'] ?? 0 }}</h3>
        <p>💾 Ressources</p>
    </div>
</a>
 {{-- A HREF IS FOR THE ROUTING TO THE DEMAND PAGE WHEN U CLICK ON THE DEMANDES CARD AS AN ADMIN --}}
    <a href="{{ route('admin.demandes.index') }}" style="text-decoration:none; color:inherit;">
    <div class="stat-card">
        <h3 id="pendingRequests">{{ $stats['pending_requests'] ?? 0 }}</h3>
        <p>⚠️ Demandes</p>
    </div>

</a>

</div>

<!-- Actions Rapides -->
<h3 style="margin-bottom: 15px;">⚡ Actions rapides</h3>
<div class="quick-actions">

{{-- CREATE USER DFEATURE FOR LATER IF WE WANT IT ADDED --}}
 <a href="{{ route('admin.users.create') }}" class="action-card"> 
     <div style="font-size: 36px; margin-bottom: 10px;">➕</div>
    <div>Créer utilisateur</div>
    </a>
    <a href="{{ route('admin.ressources.index') }}" class="action-card">
        <div style="font-size: 36px; margin-bottom: 10px;">🖥️</div>
        <div>Ajouter ressource</div>
    </a>
    <a href="{{ route('admin.reservations.index') }}" class="action-card">
        <div style="font-size: 36px; margin-bottom: 10px;">📋</div>
        <div>Voir réservations</div>
    </a>
   {{--TO ADD LATER ADMIN STATISTICS --}}
    <a href="{{ route('admin.statistics') }}" class="action-card">
    <div style="font-size: 36px; margin-bottom: 10px;">📊</div>
        <div>Statistiques</div>
    </a>
</div>


<!-- Réservations Récentes -->
<div class="chart-container">
    <h3 style="margin-bottom: 20px;">📌 Réservations récentes</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Ressource</th>
                <th>Début</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent_reservations as $reservation)
            <tr>
                <td>#{{ $reservation->id }}</td>
                <td>{{ $reservation->demandeur->nom }} {{ $reservation->demandeur->prenom }}</td>
                <td>{{ $reservation->ressource->nom }}</td>
                <td>{{ $reservation->debut->format('d/m/Y H:i') }}</td>

                <td>
                    @if($reservation->statut == 'en_attente')
                        <span class="badge badge-warning">En attente</span>
                    @elseif($reservation->statut == 'approuvee')
                        <span class="badge badge-success">Approuvée</span>
                    @else
                        <span class="badge">{{ ucfirst($reservation->statut) }}</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.reservations.index', $reservation->id) }}" class="btn btn-sm">Voir</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: #7f8c8d;">
                    Aucune réservation récente
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des compteurs
    animateCounters();
    
    // Graphique d'activité
    drawActivityChart();
    
    // Auto-refresh toutes les 30 secondes
    setInterval(function() {
        location.reload();
    }, 30000);
});

function animateCounters() {
    const counters = [
        { id: 'totalUsers', target: {{ $stats['total_users'] ?? 0 }} },
        { id: 'totalRessources', target: {{ $stats['total_ressources'] ?? 0 }} },
        { id: 'pendingReservations', target: {{ $stats['pending_reservations'] ?? 0 }} },
        { id: 'pendingRequests', target: {{ $stats['pending_requests'] ?? 0 }} }
    ];

    counters.forEach(counter => {
        const element = document.getElementById(counter.id);
        let current = 0;
        const increment = counter.target / 50;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= counter.target) {
                element.textContent = counter.target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current);
            }
        }, 20);
    });
}

function drawActivityChart() {
    const canvas = document.getElementById('activityChart');
    const ctx = canvas.getContext('2d');
    canvas.width = canvas.offsetWidth;
    canvas.height = 300;

              // Données des 7 derniers jours (depuis backend)
              const days = @json($activity_data['days']);
              const data = @json($activity_data['values']);
                  
    const maxValue = Math.max(...data) * 1.2;
    const barWidth = canvas.width / days.length;
    const chartHeight = canvas.height - 50;

    data.forEach((value, index) => {
        const barHeight = (value / maxValue) * chartHeight;
        const x = index * barWidth + 20;
        const y = canvas.height - barHeight - 30;

        // Gradient
        const gradient = ctx.createLinearGradient(0, y, 0, canvas.height - 30);
        gradient.addColorStop(0, '#667eea');
        gradient.addColorStop(1, '#764ba2');

        ctx.fillStyle = gradient;
        ctx.fillRect(x, y, barWidth - 40, barHeight);

        // Labels
        ctx.fillStyle = '#2c3e50';
        ctx.font = '12px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(days[index], x + (barWidth - 40) / 2, canvas.height - 10);
        
        ctx.font = 'bold 14px sans-serif';
        ctx.fillText(value, x + (barWidth - 40) / 2, y - 5);
    });
}

// Redessiner au resize
window.addEventListener('resize', drawActivityChart);
</script>
@endsection