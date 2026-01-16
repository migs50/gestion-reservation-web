@extends('layouts.app')

@section('title', 'Mes Réservations')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    .page-header {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h1 {
        font-size: 28px;
        color: #2c3e50;
    }

    .btn-primary {
        padding: 12px 25px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
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

    .reservations-list {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .reservation-card {
        padding: 25px;
        border-bottom: 1px solid #ecf0f1;
        transition: background 0.3s ease;
    }

    .reservation-card:hover {
        background: #f8f9fa;
    }

    .reservation-card:last-child {
        border-bottom: none;
    }

    .reservation-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 15px;
    }

    .reservation-title {
        flex: 1;
    }

    .reservation-title h3 {
        font-size: 20px;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .reservation-title p {
        color: #7f8c8d;
        font-size: 14px;
    }

    .reservation-body {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #555;
        font-size: 14px;
    }

    .info-item span:first-child {
        font-size: 18px;
    }

    .reservation-actions {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: #3498db;
        color: white;
    }

    .btn-view:hover {
        background: #2980b9;
    }

    .btn-cancel {
        background: #e74c3c;
        color: white;
    }

    .btn-cancel:hover {
        background: #c0392b;
    }

    .btn-extend {
        background: #f39c12;
        color: white;
    }

    .btn-extend:hover {
        background: #d68910;
    }

    .badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-warning { background: #fff3cd; color: #856404; }
    .badge-success { background: #d4edda; color: #155724; }
    .badge-danger { background: #f8d7da; color: #721c24; }
    .badge-info { background: #d1ecf1; color: #0c5460; }
    .badge-secondary { background: #e2e3e5; color: #383d41; }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #7f8c8d;
    }

    .empty-state span {
        font-size: 64px;
        display: block;
        margin-bottom: 20px;
    }

    .pagination {
        padding: 25px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .reservation-header {
            flex-direction: column;
            gap: 10px;
        }

        .reservation-actions {
            flex-wrap: wrap;
        }
    }
</style>

<!-- Header -->
<div class="page-header">
    <h1>📋 Mes Réservations</h1>
    <a href="{{ route('user.reservation.create') }}" class="btn-primary">
        ➕ Nouvelle réservation
    </a>
</div>

<!-- Filters -->
<div class="filters-card">
    <form action="{{ route('user.reservations') }}" method="GET" class="filters-form">
        <div class="form-group">
            <label>Statut</label>
            <select name="statut">
                <option value="">Tous les statuts</option>
                <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="approuvee" {{ request('statut') == 'approuvee' ? 'selected' : '' }}>Approuvée</option>
                <option value="refusee" {{ request('statut') == 'refusee' ? 'selected' : '' }}>Refusée</option>
                <option value="active" {{ request('statut') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="terminee" {{ request('statut') == 'terminee' ? 'selected' : '' }}>Terminée</option>
            </select>
        </div>

        <div class="form-group">
            <label>Date début</label>
            <input type="date" name="date_debut" value="{{ request('date_debut') }}">
        </div>

        <div class="form-group">
            <label>Date fin</label>
            <input type="date" name="date_fin" value="{{ request('date_fin') }}">
        </div>

        <div class="form-group">
            <button type="submit" class="btn-filter">🔍 Filtrer</button>
        </div>
    </form>
</div>

<!-- Reservations List -->
<div class="reservations-list">
    @forelse($reservations as $reservation)
    <div class="reservation-card">
        <div class="reservation-header">
            <div class="reservation-title">
                <h3>{{ $reservation->ressource->nom }}</h3>
                <p>{{ $reservation->ressource->categorie->nom ?? 'Non catégorisé' }}</p>
            </div>
            <div>
                @switch($reservation->statut)
                    @case('en_attente')
                        <span class="badge badge-warning">⏳ En attente</span>
                        @break
                    @case('approuvee')
                        <span class="badge badge-success">✅ Approuvée</span>
                        @break
                    @case('refusee')
                        <span class="badge badge-danger">❌ Refusée</span>
                        @break
                    @case('active')
                        <span class="badge badge-info">🔄 Active</span>
                        @break
                    @case('terminee')
                        <span class="badge badge-secondary">✓ Terminée</span>
                        @break
                @endswitch
            </div>
        </div>

        <div class="reservation-body">
            <div class="info-item">
                <span>📅</span>
                <div>
                    <strong>Début:</strong><br>
                    {{ $reservation->date_debut->format('d/m/Y H:i') }}
                </div>
            </div>

            <div class="info-item">
                <span>📅</span>
                <div>
                    <strong>Fin:</strong><br>
                    {{ $reservation->date_fin->format('d/m/Y H:i') }}
                </div>
            </div>

            <div class="info-item">
                <span>⏱️</span>
                <div>
                    <strong>Durée:</strong><br>
                    {{ $reservation->date_debut->diffInDays($reservation->date_fin) }} jours
                </div>
            </div>

            <div class="info-item">
                <span>📝</span>
                <div>
                    <strong>Référence:</strong><br>
                    #{{ $reservation->id }}
                </div>
            </div>
        </div>

        <div class="reservation-actions">
            <a href="{{ route('user.reservation.show', $reservation->id) }}" class="btn btn-view">
                👁️ Voir détails
            </a>

            @if($reservation->statut == 'en_attente' || $reservation->statut == 'approuvee')
            <form action="{{ route('user.reservation.cancel', $reservation->id) }}" method="POST" style="display: inline;" 
                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-cancel">
                    🗑️ Annuler
                </button>
            </form>
            @endif

            @if($reservation->statut == 'active')
            <a href="{{ route('user.reservation.extend', $reservation->id) }}" class="btn btn-extend">
                ⏰ Prolonger
            </a>
            @endif
        </div>
    </div>
    @empty
    <div class="empty-state">
        <span>📭</span>
        <h3>Aucune réservation trouvée</h3>
        <p>Vous n'avez pas encore de réservation</p>
        <a href="{{ route('user.reservation.create') }}" class="btn-primary" style="margin-top: 20px;">
            ➕ Créer une réservation
        </a>
    </div>
    @endforelse

    @if($reservations->hasPages())
    <div class="pagination">
        {{ $reservations->links() }}
    </div>
    @endif
</div>

@if(session('success'))
<script>
    alert('✅ {{ session('success') }}');
</script>
@endif
