@extends('layouts.admin')

@section('title', 'Gestion Ressources')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

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
    .resource-status-indicator {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 5px;
    }
    .status-disponible { background: #48bb78; }
    .status-occupe { background: #f6ad55; }
    .status-maintenance { background: #e74c3c; }
    .status-hors_service { background: #95a5a6; }
</style>

<div class="page-header">
    <h2>💾 Gestion des Ressources ({{ $ressources->total() }})</h2>
    <a href="{{ route('admin.ressources.create') }}" class="btn btn-primary">➕ Nouvelle ressource</a>
</div>

<!-- Filtres -->
<form method="GET" action="{{ route('admin.ressources') }}" class="filters" id="filterForm">
    <select name="categorie" onchange="this.form.submit()">
        <option value="">Toutes catégories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>
                {{ $cat->nom }}
            </option>
        @endforeach
    </select>

    <select name="statut" id="statutFilter" onchange="this.form.submit()">
        <option value="">Tous statuts</option>
        <option value="disponible" {{ request('statut') == 'disponible' ? 'selected' : '' }}>Disponible</option>
        <option value="occupe" {{ request('statut') == 'occupe' ? 'selected' : '' }}>Occupé</option>
        <option value="maintenance" {{ request('statut') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        <option value="hors_service" {{ request('statut') == 'hors_service' ? 'selected' : '' }}>Hors service</option>
    </select>

    <button type="button" class="btn btn-secondary" onclick="exportToCSV()">📥 Exporter CSV</button>
</form>

@if(session('success'))
<div class="alert alert-success" id="successAlert">{{ session('success') }}</div>
@endif

<!-- Table -->
<div class="card">
    <table class="table" id="ressourcesTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Statut</th>
                <th>Responsable</th>
                <th>Spécifications</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ressources as $ressource)
            <tr data-status="{{ $ressource->statut }}">
                <td>#{{ $ressource->id }}</td>
                <td><strong>{{ $ressource->nom }}</strong></td>
                <td>
                    <span class="badge badge-info">{{ $ressource->categorie->nom ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="resource-status-indicator status-{{ $ressource->statut }}"></span>
                    @switch($ressource->statut)
                        @case('disponible')
                            <span class="badge badge-success">Disponible</span>
                            @break
                        @case('occupe')
                            <span class="badge badge-warning">Occupé</span>
                            @break
                        @case('maintenance')
                            <span class="badge badge-danger">Maintenance</span>
                            @break
                        @case('hors_service')
                            <span class="badge badge-secondary">Hors service</span>
                            @break
                    @endswitch
                </td>
                <td>{{ $ressource->responsable->nom ?? 'Non assigné' }}</td>
                <td>
                    <button class="btn btn-sm" onclick="showSpecs({{ $ressource->id }})">👁️ Voir</button>
                </td>
                <td>
                    <a href="{{ route('admin.ressources.edit', $ressource->id) }}" class="btn btn-sm">✏️</a>
                    <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $ressource->id }}, '{{ $ressource->nom }}')">🗑️</button>
                    <form id="delete-form-{{ $ressource->id }}" action="{{ route('admin.ressources.destroy', $ressource->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 40px;">Aucune ressource trouvée</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="padding: 20px;">
        {{ $ressources->links() }}
    </div>
</div>

<!-- Modal Spécifications -->
<div id="specsModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 10px; max-width: 600px; width: 90%;">
        <h3 style="margin-bottom: 20px;">📋 Spécifications Techniques</h3>
        <div id="specsContent"></div>
        <button onclick="closeSpecs()" class="btn btn-primary" style="margin-top: 20px;">Fermer</button>
    </div>
</div>

<script>
const ressourcesData = @json($ressources->map(function($r) {
    return [
        'id' => $r->id,
        'nom' => $r->nom,
        'specifications' => $r->specifications
    ];
}));

function showSpecs(ressourceId) {
    const ressource = ressourcesData.find(r => r.id === ressourceId);
    if (!ressource) return;

    const specs = typeof ressource.specifications === 'string' 
        ? JSON.parse(ressource.specifications) 
        : ressource.specifications;

    let html = '<div style="line-height: 2;">';
    for (const [key, value] of Object.entries(specs || {})) {
        html += `<div><strong>${key}:</strong> ${value}</div>`;
    }
    html += '</div>';

    document.getElementById('specsContent').innerHTML = html;
    document.getElementById('specsModal').style.display = 'flex';
}

function closeSpecs() {
    document.getElementById('specsModal').style.display = 'none';
}

function confirmDelete(id, name) {
    if (confirm(`Supprimer la ressource "${name}" ?`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}

function exportToCSV() {
    const table = document.getElementById('ressourcesTable');
    let csv = [];
    
    // Headers
    const headers = [];
    table.querySelectorAll('thead th').forEach(th => {
        headers.push(th.textContent.trim());
    });
    csv.push(headers.join(','));
    
    // Rows
    table.querySelectorAll('tbody tr').forEach(tr => {
        const row = [];
        tr.querySelectorAll('td').forEach((td, index) => {
            if (index < 6) row.push('"' + td.textContent.trim().replace(/"/g, '""') + '"');
        });
        if (row.length) csv.push(row.join(','));
    });
    
    // Download
    const blob = new Blob([csv.join('\n')], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'ressources_' + new Date().toISOString().slice(0,10) + '.csv';
    a.click();
}

// Auto-hide alerts
setTimeout(() => {
    const alert = document.getElementById('successAlert');
    if (alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);
</script>
@endsection