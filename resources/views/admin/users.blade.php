@extends('layouts.admin')

@section('title', 'Gestion Utilisateurs')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    .filters {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    .filters select,
    .filters input {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        flex: 1;
        min-width: 200px;
    }
    .highlighted-row {
        background: #fff9e6 !important;
    }
</style>

<div class="page-header">
    <h2>👥 Gestion des Utilisateurs ({{ $users->total() }})</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">➕ Nouvel utilisateur</a>
</div>

<!-- Filtres -->
<form method="GET" action="{{ route('admin.users') }}" class="filters" id="filterForm">
    <select name="role" id="roleFilter" onchange="applyFilters()">
        <option value="">Tous les rôles</option>
        <option value="utilisateur" {{ request('role') == 'utilisateur' ? 'selected' : '' }}>Utilisateur</option>
        <option value="responsable" {{ request('role') == 'responsable' ? 'selected' : '' }}>Responsable</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>

    <input type="text" name="search" id="searchInput" placeholder="Rechercher..." value="{{ request('search') }}">
    
    <button type="submit" class="btn">🔍 Filtrer</button>
    <button type="button" class="btn btn-secondary" onclick="resetFilters()">🔄 Réinitialiser</button>
</form>

@if(session('success'))
<div class="alert alert-success" id="successAlert">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-error" id="errorAlert">{{ session('error') }}</div>
@endif

<!-- Table -->
<div class="card">
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
                    <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'responsable' ? 'warning' : 'info') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>{{ $user->organisation ?? '-' }}</td>
                <td>
                    @if($user->actif)
                        <span class="badge badge-success">Actif</span>
                    @else
                        <span class="badge badge-secondary">Inactif</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm" title="Éditer">✏️</a>
                    
                    @if($user->id != Auth::id())
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $user->id }}, '{{ $user->nom }} {{ $user->prenom }}')" title="Supprimer">
                        🗑️
                    </button>
                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
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
    window.location.href = '{{ route("admin.users") }}';
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