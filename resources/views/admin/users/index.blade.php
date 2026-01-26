@extends('layouts.admin')

@section('title', 'Gestion Utilisateurs')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">



<div class="page-header">
    <h2> Gestion des Utilisateurs ({{ $users->total() }})</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">➕ Nouvel utilisateur</a>
</div>

<!-- Filtres -->
<form method="GET" action="{{ route('admin.users.index') }}" class="filters" id="filterForm">
    <select name="role" id="roleFilter" onchange="applyFilters()">
        <option value="">Tous les rôles</option>
        <option value="utilisateur" {{ request('role') == 'utilisateur' ? 'selected' : '' }}>Utilisateur</option>
        <option value="Responsable Technique" {{ request('role') == 'Responsable Technique' ? 'selected' : '' }}>Responsable Technique</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>

    <input type="text" name="search" id="searchInput" placeholder="Rechercher..." value="{{ request('search') }}">
    
    <button type="submit" class="btn" style="margin-top: 10px;"> Filtrer</button>
    <button type="button" class="btn btn-secondary" style="margin-top: 20px;" onclick="resetFilters()"> Réinitialiser</button>
</form>

@if(session('success'))
<div class="alert alert-success" id="successAlert">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-error" id="errorAlert">{{ session('error') }}</div>
@endif

@push('style')
<style>
    /* Optimisation de la table pour qu'elle occupe tout l'espace sans être coupée */
    .card-table {
        padding: 0 !important; /* On enlève le padding pour que la table touche les bords si besoin */
        overflow: hidden;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto; /* Permet le défilement horizontal si le tableau est trop large */
        -webkit-overflow-scrolling: touch;
    }

    .table {
        margin-bottom: 0 !important;
        width: 100%;
        min-width: 1000px; /* Force une largeur minimale pour éviter que les colonnes soient trop serrées */
    }

    .table th, .table td {
        white-space: nowrap; /* Évite que le texte passe à la ligne et déforme le tableau */
        padding: 1rem 1.5rem !important;
    }

    /* Style pour le scrollbar horizontal personnalisé */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: var(--bg-primary);
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: var(--accent-primary);
        border-radius: 4px;
    }
</style>
@endpush

<!-- Table -->
<div class="card card-table">
    <div class="table-responsive">
        <table class="table" id="usersTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)">ID ⬍</th>
                <th onclick="sortTable(1)">Nom ⬍</th>
                <th onclick="sortTable(2)">Email ⬍</th>
                <th>Rôle</th>
                <th>Organisation</th>
                <th>Statut</th>
                <th>Inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr data-user-id="{{ $user->id }}">
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
                <td>{{ $user->organisation ?? '-' }}</td>
                <td>
                    @if($user->statut === 'active')
                        <span class="badge badge-success">Actif</span>
                    @else
                        <span class="badge badge-secondary">Inactif</span>
                    @endif
                </td>
                <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</td>
                <td>
                    <div style="display: flex; gap: 5px;">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary" title="Éditer" style="padding: 5px 10px; font-size: 14px;">✏️</a>
                        
                        <form action="{{ route('admin.users.toggleStatus', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $user->statut === 'active' ? 'btn-warning' : 'btn-success' }}" 
                                    title="{{ $user->statut === 'active' ? 'Désactiver' : 'Activer' }}" 
                                    style="padding: 5px 10px; font-size: 14px;">
                                {{ $user->statut === 'active' ? '🚫' : '✅' }}
                            </button>
                        </form>

                        @if($user->id != Auth::id())
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $user->id }}, '{{ $user->nom }} {{ $user->prenom }}')" 
                                    title="Supprimer" style="padding: 5px 10px; font-size: 14px;">
                                🗑️
                            </button>
                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 40px; color: #7f8c8d;">
                    Aucun utilisateur trouvé
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

    <div style="padding: 20px;">
        {{ $users->links() }}
    </div>
</div>

<script>
// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    });
});

// Recherche en temps réel
let searchTimeout;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        filterTableRows(this.value);
    }, 300);
});

function filterTableRows(searchTerm) {
    const table = document.getElementById('usersTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    
    Array.from(rows).forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm.toLowerCase()) ? '' : 'none';
    });
}

function applyFilters() {
    document.getElementById('filterForm').submit();
}

function resetFilters() {
    document.getElementById('roleFilter').value = '';
    document.getElementById('searchInput').value = '';
    window.location.href = '{{ route("admin.users.index") }}';
}

function confirmDelete(userId, userName) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer l'utilisateur "${userName}" ?\n\nCette action est irréversible.`)) {
        document.getElementById('delete-form-' + userId).submit();
    }
}

// Tri de table
function sortTable(columnIndex) {
    const table = document.getElementById('usersTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = Array.from(tbody.getElementsByTagName('tr'));
    
    rows.sort((a, b) => {
        const aText = a.getElementsByTagName('td')[columnIndex].textContent;
        const bText = b.getElementsByTagName('td')[columnIndex].textContent;
        return aText.localeCompare(bText);
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

// Highlight row au survol
document.querySelectorAll('#usersTable tbody tr').forEach(row => {
    row.addEventListener('mouseenter', function() {
        this.classList.add('highlighted-row');
    });
    row.addEventListener('mouseleave', function() {
        this.classList.remove('highlighted-row');
    });
});
</script>
@endsection