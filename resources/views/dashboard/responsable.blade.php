

@extends('layouts.app')

@section('title', 'Tableau de bord Responsable')
@section('breadcrumb', 'Dashboard Responsable')

@section('content')
    
{{-- Page Header --}}
<div class="page-header">
    <div class="header-content">
        <h1 class="page-title"> Bonjour, {{ Auth::user()->nom }}</h1>
        <p class="page-subtitle">
            Vous gérez actuellement <strong>{{ $totalResources }}</strong> ressource(s) avec <strong>{{ $pendingRequests }}</strong> demande(s) en attente
        </p>
    </div>
</div>

{{-- Quick Stats --}}
<div class="quick-stats">
    <div class="stat-card purple" onclick="window.location.href='{{ route('responsable.ressources') }}'">
        <div class="stat-header">
            <div class="stat-icon purple"></div>
            <span class="stat-trend {{ $resourceTrend >= 0 ? 'trend-up' : 'trend-down' }}">
                {{ $resourceTrend >= 0 ? '↑' : '↓' }} {{ abs($resourceTrend) }}%
            </span>
        </div>
        <div class="stat-value">{{ $totalResources }}</div>
        <div class="stat-label">Mes ressources</div>
    </div>

    <div class="stat-card orange" onclick="window.location.href='{{ route('responsable.requests') }}'">
        <div class="stat-header">
            <div class="stat-icon orange"></div>
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

    <div class="stat-card blue" onclick="window.location.href='{{ route('responsable.discussions') }}'">
        <div class="stat-header">
            <span class="stat-trend trend-up">Admin</span>
        </div>
        <div class="stat-value">💬</div>
        <div class="stat-label">Modération</div>
    </div>
</div>

{{-- Main Dashboard Grid --}}
<div class="dashboard-grid">
    {{-- Pending Requests --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <span></span>
                <span>Demandes en attente</span>
            </h2>
            <span class="badge badge-warning">{{ $pendingRequests }} nouvelle(s)</span>
        </div>

        <div class="request-list">
            @forelse($requests as $request)
                <div class="request-item">
                    <div class="request-header">
                        <div class="request-info">
                            <h4>{{ $request->ressource->nom }}</h4>
                            <p>
                                <span></span>
                                <span>{{ $request->demandeur->nom }} {{ $request->demandeur->prenom }}</span>
                                <span>•</span>
                                <span>Du {{ $request->debut->format('d/m/Y') }} au {{ $request->fin->format('d/m/Y') }}</span>
                            </p>
                        </div>
                        <span class="request-status {{ ($request->is_urgent ?? false) ? 'status-urgent' : 'status-pending' }}">
                            {{ ($request->is_urgent ?? false) ? '🔥 Urgent' : '⏳ En attente' }}
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
                             Détails
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
                <span></span>
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