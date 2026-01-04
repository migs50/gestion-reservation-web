

@extends('layouts.app')

@section('title', 'Tableau de bord Responsable')
@section('breadcrumb', 'Dashboard Responsable')

@section('content')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 35px;
        color: white;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-content {
        position: relative;
        z-index: 1;
    }

    .welcome-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .welcome-subtitle {
        font-size: 16px;
        opacity: 0.95;
    }

    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        cursor: pointer;
        border-left: 5px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    }

    .stat-card.purple { border-left-color: #667eea; }
    .stat-card.orange { border-left-color: #ed8936; }
    .stat-card.green { border-left-color: #48bb78; }
    .stat-card.red { border-left-color: #f56565; }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 18px;
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .stat-icon.purple { background: rgba(102, 126, 234, 0.12); }
    .stat-icon.orange { background: rgba(237, 137, 54, 0.12); }
    .stat-icon.green { background: rgba(72, 187, 120, 0.12); }
    .stat-icon.red { background: rgba(245, 101, 101, 0.12); }

    .stat-trend {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }

    .trend-up {
        background: rgba(72, 187, 120, 0.12);
        color: #48bb78;
    }

    .trend-down {
        background: rgba(245, 101, 101, 0.12);
        color: #f56565;
    }

    .stat-value {
        font-size: 38px;
        font-weight: 800;
        color: #2d3748;
        margin-bottom: 8px;
        line-height: 1;
    }

    .stat-label {
        font-size: 15px;
        color: #718096;
        font-weight: 600;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
        margin-bottom: 30px;
    }

    .card {
        background: white;
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 18px;
        border-bottom: 2px solid #f7fafc;
    }

    .card-title {
        font-size: 22px;
        font-weight: 800;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }

    .badge-warning {
        background: rgba(237, 137, 54, 0.12);
        color: #ed8936;
    }

    .badge-info {
        background: rgba(66, 153, 225, 0.12);
        color: #4299e1;
    }

    .request-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
        max-height: 600px;
        overflow-y: auto;
    }

    .request-item {
        padding: 20px;
        background: #f7fafc;
        border-radius: 14px;
        transition: all 0.3s;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .request-item:hover {
        background: white;
        border-color: #667eea;
        transform: translateX(8px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .request-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .request-info h4 {
        font-size: 16px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 6px;
    }

    .request-info p {
        font-size: 13px;
        color: #718096;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .request-status {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-pending {
        background: rgba(237, 137, 54, 0.12);
        color: #ed8936;
    }

    .status-urgent {
        background: rgba(245, 101, 101, 0.12);
        color: #f56565;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }

    .request-actions {
        display: flex;
        gap: 10px;
        margin-top: 12px;
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-approve {
        background: #48bb78;
        color: white;
    }

    .btn-approve:hover {
        background: #38a169;
        transform: translateY(-2px);
    }

    .btn-reject {
        background: #f56565;
        color: white;
    }

    .btn-reject:hover {
        background: #e53e3e;
        transform: translateY(-2px);
    }

    .btn-view {
        background: #4299e1;
        color: white;
    }

    .btn-view:hover {
        background: #3182ce;
        transform: translateY(-2px);
    }

    .resource-summary {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .resource-item {
        padding: 18px;
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        border-radius: 12px;
        transition: all 0.3s;
    }

    .resource-item:hover {
        transform: scale(1.03);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .resource-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .resource-name {
        font-weight: 700;
        color: #2d3748;
        font-size: 15px;
    }

    .resource-count {
        font-size: 20px;
        font-weight: 800;
        color: #667eea;
    }

    .resource-bar {
        height: 8px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 8px;
    }

    .resource-fill {
        height: 100%;
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    .fill-high { background: #f56565; }
    .fill-medium { background: #ed8936; }
    .fill-low { background: #48bb78; }

    .resource-info {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #718096;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #718096;
    }

    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 15px;
    }

    @media (max-width: 1024px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .quick-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- Welcome Banner --}}
<div class="welcome-banner">
    <div class="welcome-content">
        <h1 class="welcome-title">👋 Bonjour, {{ Auth::user()->name }}</h1>
        <p class="welcome-subtitle">
            Vous gérez actuellement <strong>{{ $totalResources }}</strong> ressource(s) avec <strong>{{ $pendingRequests }}</strong> demande(s) en attente
        </p>
    </div>
</div>

{{-- Quick Stats --}}
<div class="quick-stats">
    <div class="stat-card purple" onclick="window.location.href='{{ route('responsable.ressources') }}'">
        <div class="stat-header">
            <div class="stat-icon purple">🖥️</div>
            <span class="stat-trend {{ $resourceTrend >= 0 ? 'trend-up' : 'trend-down' }}">
                {{ $resourceTrend >= 0 ? '↑' : '↓' }} {{ abs($resourceTrend) }}%
            </span>
        </div>
        <div class="stat-value">{{ $totalResources }}</div>
        <div class="stat-label">Mes ressources</div>
    </div>

    <div class="stat-card orange" onclick="window.location.href='{{ route('responsable.requests') }}'">
        <div class="stat-header">
            <div class="stat-icon orange">⏳</div>
            <span class="stat-trend {{ $requestTrend >= 0 ? 'trend-up' : 'trend-down' }}">
                {{ $requestTrend >= 0 ? '↑' : '↓' }} {{ abs($requestTrend) }}
            </span>
        </div>
        <div class="stat-value">{{ $pendingRequests }}</div>
        <div class="stat-label">Demandes en attente</div>
    </div>

    <div class="stat-card green">
        <div class="stat-header">
            <div class="stat-icon green">✓</div>
            <span class="stat-trend trend-up">↑ {{ $approvedTrend }}%</span>
        </div>
        <div class="stat-value">{{ $approvedReservations }}</div>
        <div class="stat-label">Réservations actives</div>
    </div>

    <div class="stat-card red">
        <div class="stat-header">
            <div class="stat-icon red">⚠️</div>
            <span class="stat-trend {{ $alertTrend >= 0 ? 'trend-up' : 'trend-down' }}">
                {{ $alertTrend >= 0 ? '↑' : '↓' }} {{ abs($alertTrend) }}
            </span>
        </div>
        <div class="stat-value">{{ $activeAlerts }}</div>
        <div class="stat-label">Alertes</div>
    </div>
</div>

{{-- Main Dashboard Grid --}}
<div class="dashboard-grid">
    {{-- Pending Requests --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <span>📋</span>
                <span>Demandes en attente</span>
            </h2>
            <span class="badge badge-warning">{{ $pendingRequests }} nouvelle(s)</span>
        </div>

        <div class="request-list">
            @forelse($requests as $request)
                <div class="request-item">
                    <div class="request-header">
                        <div class="request-info">
                            <h4>{{ $request->resource->name }}</h4>
                            <p>
                                <span>👤</span>
                                <span>{{ $request->user->name }}</span>
                                <span>•</span>
                                <span>Du {{ $request->start_date->format('d/m/Y') }} au {{ $request->end_date->format('d/m/Y') }}</span>
                            </p>
                        </div>
                        <span class="request-status {{ $request->is_urgent ? 'status-urgent' : 'status-pending' }}">
                            {{ $request->is_urgent ? '🔥 Urgent' : '⏳ En attente' }}
                        </span>
                    </div>
                    <div class="request-actions">
                        <form action="{{ route('responsable.requests.approve', $request->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-sm btn-approve" onclick="return confirm('Approuver cette demande ?')">
                                ✓ Approuver
                            </button>
                        </form>
                        <form action="{{ route('responsable.requests.reject', $request->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-sm btn-reject" onclick="return confirm('Refuser cette demande ?')">
                                ✗ Refuser
                            </button>
                        </form>
                        <a href="{{ route('responsable.requests.show', $request->id) }}" class="btn-sm btn-view">
                            👁️ Détails
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">✅</div>
                    <p>Aucune demande en attente</p>
                </div>
            @endforelse
        </div>

        @if($requests->count() > 0)
            <a href="{{ route('responsable.requests') }}" style="display: block; text-align: center; margin-top: 20px; color: #667eea; font-weight: 600; text-decoration: none;">
                Voir toutes les demandes →
            </a>
        @endif
    </div>

    {{-- Resources Overview --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <span>📊</span>
                <span>Vue d'ensemble</span>
            </h2>
            <span class="badge badge-info">{{ $totalResources }} total</span>
        </div>

        <div class="resource-summary">
            @foreach($resourcesByType as $type => $data)
                <div class="resource-item">
                    <div class="resource-header">
                        <span class="resource-name">{{ ucfirst($type) }}</span>
                        <span class="resource-count">{{ $data['total'] }}</span>
                    </div>
                    <div class="resource-bar">
                        <div class="resource-fill {{ $data['percentage'] >= 80 ? 'fill-high' : ($data['percentage'] >= 50 ? 'fill-medium' : 'fill-low') }}" 
                             style="width: {{ $data['percentage'] }}%"></div>
                    </div>
                    <div class="resource-info">
                        <span>{{ $data['percentage'] }}% utilisés</span>
                        <span>{{ $data['occupied'] }}/{{ $data['total'] }} occupés</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    // Animate stats on load
    window.addEventListener('load', () => {
        document.querySelectorAll('.stat-value').forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                el.style.transition = 'all 0.5s ease-out';
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });

    // Auto-refresh every 30 seconds
    setTimeout(() => {
        location.reload();
    }, 30000);
</script>

@endsection