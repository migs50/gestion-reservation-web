@extends('layouts.admin')

@section('title', 'Dashboard Administrateur')

@section('content')

<style>
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(45, 50, 80, 0.05);
        border: 1px solid rgba(103, 111, 157, 0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 220px;
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(45, 50, 80, 0.1);
        border-color: var(--accent-primary);
    }

    .stat-number {
        font-size: 4rem;
        font-weight: 800;
        color: var(--accent-primary);
        line-height: 1;
        margin-bottom: 15px;
        font-family: 'Raleway', sans-serif;
    }

    .stat-label {
        font-size: 1.1rem;
        font-weight: 700;
        color: #424769;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .stat-icon {
        font-size: 1.8rem;
        margin-bottom: 15px;
        opacity: 0.8;
    }
    
    .chart-container {
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(45, 50, 80, 0.05);
        margin-bottom: 30px;
        border: 1px solid rgba(103, 111, 157, 0.1);
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }

    .action-card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        text-align: center;
        text-decoration: none;
        color: #424769;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid rgba(103, 111, 157, 0.1);
        font-weight: 600;
    }

    .action-card:hover {
        background: var(--accent-primary);
        color: white;
        transform: translateY(-5px);
    }
</style>

<div class="stats-row">
    <a href="{{ route('admin.users.index') }}" style="text-decoration:none;">
        <div class="stat-card">
            <div class="stat-number" id="totalUsers">{{ $stats['total_users'] ?? 0 }}</div>
            <div class="stat-label">Utilisateurs</div>
        </div>
    </a>

    <a href="{{ route('admin.ressources.index') }}" style="text-decoration:none;">
        <div class="stat-card">
            <div class="stat-number" id="totalRessources">{{ $stats['total_ressources'] ?? 0 }}</div>
            <div class="stat-label">Ressources</div>
        </div>
    </a>

    <a href="{{ route('admin.demandes.index') }}" style="text-decoration:none;">
        <div class="stat-card">
            <div class="stat-number" id="pendingRequests">{{ $stats['pending_requests'] ?? 0 }}</div>
            <div class="stat-label">Demandes</div>
        </div>
    </a>
</div>

<!-- Actions Rapides -->
<h3 style="margin-bottom: 15px; color: #2c3e50"> Actions rapides</h3>
<div class="quick-actions">

{{-- CREATE USER DFEATURE FOR LATER IF WE WANT IT ADDED --}}
    <a href="{{ route('admin.ressources.index') }}" class="action-card">
        <div style="font-size: 36px; margin-bottom: 10px;"></div>
        <div>ressource</div>
    </a>
    <a href="{{ route('admin.reservations.index') }}" class="action-card">
        <div style="font-size: 36px; margin-bottom: 10px;"></div>
        <div>Voir réservations</div>
    </a>
   {{--TO ADD LATER ADMIN STATISTICS --}}
    <a href="{{ route('admin.statistics') }}" class="action-card">
    <div style="font-size: 36px; margin-bottom: 10px;"></div>
        <div>Statistiques</div>
    </a>
</div>


<!-- Réservations Récentes -->
<div class="chart-container">
    <h3 style="margin-bottom: 20px; color: #2c3e50;"> Réservations récentes</h3>
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
                <td colspan="10" style="text-align: center; padding: 30px; color: #7f8c8d;">
                    Aucune réservation récente
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Liste des Utilisateurs -->
<div class="chart-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="color: #2c3e50;"> Utilisateurs enregistrés</h3>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm">Voir tous</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Date d'inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stats['users']->take(5) as $user)
            <tr>
                <td>#{{ $user->id }}</td>
                <td>{{ $user->nom }} {{ $user->prenom }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role)
                        <span class="badge badge-{{ $user->role->nom == 'Admin' ? 'danger' : (str_contains($user->role->nom, 'Responsable') ? 'warning' : 'info') }}">
                            {{ $user->role->nom }}
                        </span>
                    @else
                        <span class="badge badge-secondary">-</span>
                    @endif
                </td>
                <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm">Gérer</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: #7f8c8d;">
                    Aucun utilisateur enregistré
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