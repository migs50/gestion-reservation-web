

@extends('layouts.app')

@section('title', 'Demandes de Réservation - Responsable')
@section('breadcrumb', 'Demandes de Réservation')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    /* [Styles identiques au fichier précédent] */
    .page-header {
        background: linear-gradient(135deg, #424769 0%, #2d3250 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        color: white;
        display: flex;
        align-items: center;
        gap: 15px;
        margin: 0;
    }

    .stats-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-box {
        background: white;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        text-align: center;
        transition: all 0.3s;
    }

    .stat-box:hover {
        transform: translateY(-5px);
    }

    .stat-number {
        font-size: 36px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .stat-number.pending { color: #ed8936; }
    .stat-number.approved { color: #48bb78; }
    .stat-number.rejected { color: #f56565; }
    .stat-number.total { color: #4299e1; }

    .stat-label {
        font-size: 14px;
        color: #718096;
        font-weight: 600;
    }

    .filters-bar {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .filters-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 15px;
        align-items: end;
    }

    .filter-input, .filter-select {
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
    }

    .btn-filter {
        padding: 12px 20px;
        background: #2d3250;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
    }

    .requests-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .request-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        border-left: 5px solid #ed8936;
    }

    .request-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transform: translateX(5px);
    }

    .request-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f7fafc;
    }

    .request-title {
        font-size: 20px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .request-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 14px;
        color: #718096;
    }

    .request-status {
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }

    .status-pending {
        background: rgba(237, 137, 54, 0.12);
        color: #ed8936;
    }

    .status-approved {
        background: rgba(72, 187, 120, 0.12);
        color: #48bb78;
    }

    .status-rejected {
        background: rgba(245, 101, 101, 0.12);
        color: #f56565;
    }

    .status-urgent {
        background: rgba(245, 101, 101, 0.12);
        color: #f56565;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .request-message {
        background: #f7fafc;
        border-left: 4px solid #4299e1;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .message-header {
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .message-text {
        color: #4a5568;
        font-size: 14px;
        line-height: 1.6;
    }

    .request-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-approve {
        background: #48bb78;
        color: white;
        flex: 1;
    }

    .btn-reject {
        background: #f56565;
        color: white;
        flex: 1;
    }

    .btn-details {
        background: #f9b17a;
        color: white;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .filters-row {
            grid-template-columns: 1fr;
        }
        .request-actions {
            flex-direction: column;
        }
    }
</style>

{{-- Page Header --}}
<div class="page-header">
    <h1 class="page-title">
        <span></span>
        Demandes de Réservation
    </h1>
</div>

{{-- Stats Summary --}}
<div class="stats-summary">
    <div class="stat-box">
        <div class="stat-number pending">{{ $stats['pending'] }}</div>
        <div class="stat-label">En attente</div>
    </div>
    <div class="stat-box">
        <div class="stat-number approved">{{ $stats['approved'] }}</div>
        <div class="stat-label">Approuvées</div>
    </div>
    <div class="stat-box">
        <div class="stat-number rejected">{{ $stats['rejected'] }}</div>
        <div class="stat-label">Refusées</div>
    </div>
    <div class="stat-box">
        <div class="stat-number total">{{ $stats['total'] }}</div>
        <div class="stat-label">Total</div>
    </div>
</div>

{{-- Filters --}}
<div class="filters-bar">
    <form action="{{ route('responsable.requests') }}" method="GET">
        <div class="filters-row">
            <input 
                type="text" 
                name="search"
                class="filter-input" 
                placeholder="Utilisateur, ressource, ID..."
                value="{{ request('search') }}"
            >

            <select name="status" class="filter-select">
                <option value="">Tous les statuts</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvé</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Refusé</option>
            </select>

            <select name="urgent" class="filter-select">
                <option value="">Toutes</option>
                <option value="1" {{ request('urgent') == '1' ? 'selected' : '' }}>Urgentes</option>
                <option value="0" {{ request('urgent') == '0' ? 'selected' : '' }}>Normales</option>
            </select>

            <button type="submit" class="btn-filter">
                🔍 Filtrer
            </button>
        </div>
    </form>
</div>

{{-- Requests List --}}
<div class="requests-container">
    @forelse($requests as $request)
        <div class="request-card">
            <div class="request-header">
                <div>
                    <div class="request-title">
                        @php
                            $icon = '';
                            if($request->ressource && $request->ressource->categorie) {
                                if(str_contains(strtolower($request->ressource->categorie->nom), 'serveur')) $icon = '🗄️';
                                if(str_contains(strtolower($request->ressource->categorie->nom), 'virtuel')) $icon = '☁️';
                                if(str_contains(strtolower($request->ressource->categorie->nom), 'stockage')) $icon = '💾';
                                if(str_contains(strtolower($request->ressource->categorie->nom), 'réseau')) $icon = '🌐';
                            }
                        @endphp
                        {{ $icon }} {{ $request->ressource->nom }}
                        <span style="font-size: 14px; color: #a0aec0; font-weight: 600;">#REQ-{{ $request->id }}</span>
                    </div>
                    <div class="request-meta">
                        <span> {{ $request->demandeur->nom }} {{ $request->demandeur->prenom }}</span>
                        <span>•</span>
                        <span> Du {{ $request->debut->format('d/m/Y') }} au {{ $request->fin->format('d/m/Y') }}</span>
                        <span>•</span>
                        <span> {{ $request->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <span class="request-status status-{{ $request->statut }}">
                    {{ ucfirst($request->statut) }}
                </span>
            </div>

            @if($request->justification)
                <div class="request-message">
                    <div class="message-header"> Justification de l'utilisateur</div>
                    <p class="message-text">{{ $request->justification }}</p>
                </div>
            @endif

            <div class="request-actions">
                @if($request->statut === 'pending')
                    <form action="{{ route('responsable.requests.approve', $request->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" class="action-btn btn-approve" onclick="return confirm('Approuver cette demande ?')" style="width: 100%;">
                            <span>✓</span>
                            <span>Approuver</span>
                        </button>
                    </form>

                    <form action="{{ route('responsable.requests.reject', $request->id) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" class="action-btn btn-reject" onclick="return confirm('Refuser cette demande ?')" style="width: 100%;">
                            <span>✗</span>
                            <span>Refuser</span>
                        </button>
                    </form>
                @endif

                <a href="{{ route('responsable.requests.show', $request->id) }}" class="action-btn btn-details" style="{{ $request->statut !== 'pending' ? 'flex: 1; justify-content: center;' : '' }}">
                    <span></span>
                    <span>Détails complets</span>
                </a>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 60px; background: white; border-radius: 15px;">
            <div style="font-size: 80px; margin-bottom: 20px;">✅</div>
            <h3 style="font-size: 24px; font-weight: 700; color: #2d3748; margin-bottom: 10px;">Aucune demande trouvée</h3>
            <p style="color: #718096; font-size: 16px;">Toutes les demandes ont été traitées ou aucune ne correspond aux filtres</p>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($requests->hasPages())
    <div style="margin-top: 30px;">
        {{ $requests->appends(request()->query())->links() }}
    </div>
@endif

@endsection