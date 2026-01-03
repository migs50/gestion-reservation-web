@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .categories-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
    }
    .form-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        height: fit-content;
        position: sticky;
        top: 20px;
    }
    .form-card h3 {
        margin-bottom: 20px;
        color: #2c3e50;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2c3e50;
    }
    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }
    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }
    .categories-list {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .category-item {
        padding: 18px;
        background: #f8f9fa;
        margin-bottom: 12px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s;
        cursor: move;
        border-left: 5px solid #667eea;
    }
    .category-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }
    .category-item.dragging {
        opacity: 0.5;
        transform: scale(0.95);
    }
    .category-info {
        flex: 1;
    }
    .category-name {
        font-size: 16px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    .category-description {
        font-size: 13px;
        color: #7f8c8d;
    }
    .category-meta {
        display: flex;
        gap: 15px;
        align-items: center;
        color: #7f8c8d;
        font-size: 13px;
    }
    .category-actions {
        display: flex;
        gap: 8px;
    }
    .drag-handle {
        cursor: move;
        font-size: 20px;
        color: #95a5a6;
        margin-right: 15px;
    }
    .color-picker {
        width: 50px;
        height: 40px;
        border: 1px solid #ddd;
        border-radius: 6px;
        cursor: pointer;
    }
    .empty-state {
        text-align: center;
        padding: 60px;
        color: #7f8c8d;
    }
    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 15px;
    }
    @media (max-width: 768px) {
        .categories-grid {
            grid-template-columns: 1fr;
        }
        .form-card {
            position: static;
        }
    }
</style>

<div class="page-header">
    <h2>📁 Gestion des Catégories ({{ $categories->count() }})</h2>
    <button onclick="resetForm()" class="btn btn-secondary">🔄 Réinitialiser</button>
</div>

@if(session('success'))
<div class="alert alert-success" id="successAlert">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul style="margin: 0; padding-left: 20px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="categories-grid">
    <!-- Formulaire de création/édition -->
    <div class="form-card">
        <h3 id="formTitle">➕ Nouvelle Catégorie</h3>
        
        <form id="categoryForm" action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <input type="hidden" id="categoryId" name="id">
            <input type="hidden" id="formMethod" name="_method" value="POST">
            
            <div class="form-group">
                <label for="nom">Nom de la catégorie *</label>
                <input type="text" id="nom" name="nom" required placeholder="Ex: Serveurs, Stockage...">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Description détaillée de la catégorie..."></textarea>
            </div>

            <div class="form-group">
                <label for="couleur">Couleur d'identification</label>
                <input type="color" id="couleur" name="couleur" class="color-picker" value="#667eea">
            </div>

            <div class="form-group">
                <label for="icone">Icône (emoji ou code)</label>
                <input type="text" id="icone" name="icone" placeholder="Ex: 🖥️, 💾, 🌐">
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" id="actif" name="actif" checked>
                    Catégorie active
                </label>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    💾 Enregistrer
                </button>
                <button type="button" onclick="resetForm()" class="btn btn-secondary">
                    ✕ Annuler
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des catégories -->
    <div class="categories-list">
        <h3 style="margin-bottom: 20px;">📋 Liste des catégories</h3>
        
        <div style="margin-bottom: 15px; padding: 12px; background: #e3f2fd; border-radius: 6px; font-size: 13px;">
            💡 <strong>Astuce:</strong> Glissez-déposez les catégories pour changer leur ordre d'affichage
        </div>

        <div id="categoriesList">
            @forelse($categories as $categorie)
            <div class="category-item" draggable="true" data-id="{{ $categorie->id }}" data-order="{{ $categorie->ordre ?? 0 }}">
                <span class="drag-handle">⋮⋮</span>
                
                <div class="category-info">
                    <div class="category-name">
                        @if($categorie->icone)
                            <span style="margin-right: 8px;">{{ $categorie->icone }}</span>
                        @endif
                        {{ $categorie->nom }}
                    </div>
                    
                    @if($categorie->description)
                        <div class="category-description">{{ Str::limit($categorie->description, 80) }}</div>
                    @endif
                    
                    <div class="category-meta">
                        <span>
                            <span style="display: inline-block; width: 16px; height: 16px; border-radius: 50%; background: {{ $categorie->couleur ?? '#667eea' }}; vertical-align: middle; margin-right: 5px;"></span>
                            Couleur
                        </span>
                        <span>📦 {{ $categorie->ressources_count ?? 0 }} ressources</span>
                        <span>
                            @if($categorie->actif)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">Inactive</span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="category-actions">
                    <button type="button" class="btn btn-sm" onclick="editCategory({{ $categorie->id }})" title="Éditer">
                        ✏️
                    </button>
                    <form action="{{ route('admin.categories.destroy', $categorie->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette catégorie ? Les ressources associées ne seront pas supprimées.')" title="Supprimer">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-state-icon">📁</div>
                <p style="font-size: 18px; font-weight: 600; margin-bottom: 10px;">Aucune catégorie</p>
                <p>Créez votre première catégorie pour organiser vos ressources</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
// Données des catégories pour édition
const categoriesData = @json($categories->map(function($c) {
    return [
        'id' => $c->id,
        'nom' => $c->nom,
        'description' => $c->description,
        'couleur' => $c->couleur ?? '#667eea',
        'icone' => $c->icone,
        'actif' => $c->actif
    ];
}));

// Édition
function editCategory(id) {
    const category = categoriesData.find(c => c.id === id);
    if (!category) return;

    document.getElementById('formTitle').textContent = '✏️ Modifier Catégorie';
    document.getElementById('categoryId').value = category.id;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('categoryForm').action = `/admin/categories/${id}`;
    
    document.getElementById('nom').value = category.nom;
    document.getElementById('description').value = category.description || '';
    document.getElementById('couleur').value = category.couleur;
    document.getElementById('icone').value = category.icone || '';
    document.getElementById('actif').checked = category.actif;

    // Scroll vers le formulaire
    document.querySelector('.form-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Reset formulaire
function resetForm() {
    document.getElementById('formTitle').textContent = '➕ Nouvelle Catégorie';
    document.getElementById('categoryId').value = '';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('categoryForm').action = '{{ route("admin.categories.store") }}';
    document.getElementById('categoryForm').reset();
    document.getElementById('couleur').value = '#667eea';
    document.getElementById('actif').checked = true;
}

// Drag & Drop pour réorganiser
let draggedElement = null;

document.querySelectorAll('.category-item').forEach(item => {
    item.addEventListener('dragstart', function(e) {
        draggedElement = this;
        this.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
    });

    item.addEventListener('dragend', function() {
        this.classList.remove('dragging');
        draggedElement = null;
    });

    item.addEventListener('dragover', function(e) {
        e.preventDefault();
        const afterElement = getDragAfterElement(document.getElementById('categoriesList'), e.clientY);
        const dragging = document.querySelector('.dragging');
        
        if (afterElement == null) {
            document.getElementById('categoriesList').appendChild(dragging);
        } else {
            document.getElementById('categoriesList').insertBefore(dragging, afterElement);
        }
    });

    item.addEventListener('drop', function(e) {
        e.preventDefault();
        saveNewOrder();
    });
});

function getDragAfterElement(container, y) {
    const draggableElements = [...container.querySelectorAll('.category-item:not(.dragging)')];

    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;

        if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
}

function saveNewOrder() {
    const items = document.querySelectorAll('.category-item');
    const order = [];
    
    items.forEach((item, index) => {
        order.push({
            id: item.dataset.id,
            ordre: index + 1
        });
    });

    // Envoyer la nouvelle ordre au serveur
    fetch('{{ route("admin.categories.reorder") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({ order: order })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Ordre sauvegardé:', data);
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la sauvegarde de l\'ordre');
    });
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

// Validation formulaire
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    const nom = document.getElementById('nom').value.trim();
    
    if (nom.length < 3) {
        e.preventDefault();
        alert('Le nom doit contenir au moins 3 caractères');
        return false;
    }
});
</script>
@endsection
