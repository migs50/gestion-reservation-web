@extends('layouts.app')

@section('title', 'Mes réservations')

@section('content')
<style>
    .reservations-container {
        padding: 20px 0;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h1 {
        font-size: 2.5rem;
        color: #2d3436;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Stats Overview */
    .stats-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-mini-card {
        background: white;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.3s ease;
    }

    .stat-mini-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-info h3 {
        font-size: 20px;
        font-weight: 700;
        color: #2d3436;
    }

    .stat-info p {
        font-size: 14px;
        color: #636e72;
        margin: 0;
    }

    /* Glass Table */
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .custom-table th {
        padding: 15px 20px;
        text-align: left;
        color: #636e72;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
    }

    .custom-table tr {
        transition: all 0.3s ease;
    }

    .custom-table tbody tr {
        background: white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }

    .custom-table tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .custom-table td {
        padding: 20px;
    }

    .custom-table td:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
        font-weight: 600;
        color: #764ba2;
    }

    .custom-table td:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    /* Status Badges */
    .badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .badge-approved { background: #e3fcef; color: #00b894; }
    .badge-pending { background: #fff9e6; color: #f1c40f; }
    .badge-refused { background: #ffebeb; color: #d63031; }
    .badge-cancelled { background: #f1f2f6; color: #636e72; }
    .badge-active { background: #eef2ff; color: #4f46e5; }

    .ressource-name {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: #2d3436;
    }

    .date-info {
        display: flex;
        flex-direction: column;
    }

    .date-info .date { font-weight: 600; color: #2d3436; }
    .date-info .time { font-size: 12px; color: #b2bec3; }

    .btn-action {
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-view {
        background: #f1f2f6;
        color: #2d3436;
    }

    .btn-view:hover {
        background: #dfe6e9;
    }
    .filters-bar {
        background: white;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .filters-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        align-items: end;
    }

    .filter-input {
        padding: 10px;
        border: 1px solid #dfe6e9;
        border-radius: 8px;
        font-size: 14px;
        width: 100%;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 700;
        color: #636e72;
        margin-bottom: 5px;
        display: block;
    }

    .btn-search {
        background: #667eea;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }
</style>

<div class="reservations-container">
    <div class="page-header">
        <h1>Mes réservations</h1>
        <a href="{{ route('catalogue') }}" class="navbar-menu a btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px;">
            ➕ Nouvelle réservation
        </a>
    </div>

    <!-- Filters Bar -->
    <div class="filters-bar">
        <form action="{{ route('reservations.index') }}" method="GET" class="filters-form">
            <div>
                <label class="filter-label">Ressource</label>
                <input type="text" name="ressource" class="filter-input" placeholder="Nom..." value="{{ request('ressource') }}">
            </div>
            <div>
                <label class="filter-label">Statut</label>
                <select name="statut" class="filter-input">
                    <option value="">Tous</option>
                    <option value="pending" {{ request('statut') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="approved" {{ request('statut') == 'approved' ? 'selected' : '' }}>Approuvée</option>
                    <option value="active" {{ request('statut') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="refused" {{ request('statut') == 'refused' ? 'selected' : '' }}>Refusée</option>
                    <option value="terminated" {{ request('statut') == 'terminated' ? 'selected' : '' }}>Terminée</option>
                </select>
            </div>
            <div>
                <label class="filter-label">Du</label>
                <input type="date" name="date_debut" class="filter-input" value="{{ request('date_debut') }}">
            </div>
            <div>
                <label class="filter-label">Au</label>
                <input type="date" name="date_fin" class="filter-input" value="{{ request('date_fin') }}">
            </div>
            <button type="submit" class="btn-search">Filtrer</button>
            <a href="{{ route('reservations.index') }}" class="btn-action btn-view" style="text-align: center;">Réinitialiser</a>
        </form>
    </div>

    <!-- Stats Summary -->
    <div class="stats-overview">
        <div class="stat-mini-card">
            <div class="stat-icon" style="background: #eef2ff; color: #4f46e5;">📊</div>
            <div class="stat-info">
                <h3>{{ $reservations->total() }}</h3>
                <p>Total demandes</p>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon" style="background: #fff9e6; color: #f1c40f;">⏳</div>
            <div class="stat-info">
                <h3>{{ $reservations->where('statut', 'pending')->count() }}</h3>
                <p>En attente</p>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-icon" style="background: #e3fcef; color: #00b894;">✅</div>
            <div class="stat-info">
                <h3>{{ $reservations->whereIn('statut', ['approved', 'active'])->count() }}</h3>
                <p>Réservations actives</p>
            </div>
        </div>
    </div>

    <div class="glass-card">
        @if($reservations->isEmpty())
            <div style="text-align: center; padding: 60px 0;">
                <div style="font-size: 60px; margin-bottom: 20px;">📅</div>
                <h3 style="color: #2d3436;">Aucune réservation pour le moment</h3>
                <p style="color: #636e72;">Commencez par explorer notre catalogue de ressources.</p>
                <a href="{{ route('catalogue') }}" class="btn-action btn-view" style="display: inline-block; margin-top: 20px;">Explorer le catalogue</a>
            </div>
        @else
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ressource</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>#{{ $reservation->id }}</td>
                            <td>
                                <div class="ressource-name">
                                    🔧 {{ $reservation->ressource->nom ?? 'Ressource inconnue' }}
                                </div>
                            </td>
                            <td>
                                <div class="date-info">
                                    <span class="date">{{ $reservation->debut?->format('d/m/Y') }}</span>
                                    <span class="time">{{ $reservation->debut?->format('H:i') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="date-info">
                                    <span class="date">{{ $reservation->fin?->format('d/m/Y') }}</span>
                                    <span class="time">{{ $reservation->fin?->format('H:i') }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $reservation->statut }}">
                                    {{ $reservation->statut == 'pending' ? 'En attente' : 
                                       ($reservation->statut == 'approved' ? 'Approuvée' : 
                                       ($reservation->statut == 'refused' ? 'Refusée' : 
                                       ($reservation->statut == 'active' ? 'Active' : $reservation->statut))) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn-action btn-view">
                                    Détails
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 30px;">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
