@extends('layouts.admin')

@section('title', 'Modifier ressource')

@push('style')
<style>
    /* Intégration avec le thème sombre de styles.css */
    body {
        background-color: var(--bg-primary) !important;
        color: var(--text-primary) !important;
    }

    h1 {
        color: var(--bg-primary) !important; /* Changer en couleur sombre pour la lisibilité */
        font-weight: 700;
        margin-bottom: 2rem;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 1rem;
    }

    form.form {
        max-width: 900px;
        margin: 0 auto;
        padding: 2.5rem;
        background: var(--bg-card);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
    }

    .form-group label {
        color: var(--accent-primary) !important; /* Couleur Pêche pour une meilleure visibilité */
        font-weight: 600;
        margin-bottom: 0.75rem;
        display: block;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        background: var(--bg-input) !important;
        border: 2px solid var(--border-color) !important;
        color: var(--text-primary) !important;
        border-radius: var(--radius-md) !important;
        padding: 0.75rem 1rem !important;
        transition: all var(--transition-base);
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: var(--accent-primary) !important;
        box-shadow: 0 0 0 4px rgba(249, 177, 122, 0.1) !important;
        outline: none;
    }

    /* Section Technique */
    .tech-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 30px;
        padding: 30px;
        background: rgba(45, 50, 80, 0.5); /* Plus sombre pour le contraste */
        border-radius: var(--radius-lg);
        border: 2px dashed var(--border-color);
    }

    .tech-title {
        grid-column: span 2;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--accent-primary);
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-submit {
        background: var(--accent-primary) !important;
        color: var(--bg-primary) !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 1px;
        width: 100%;
        padding: 1rem !important;
        border-radius: var(--radius-md) !important;
        margin-top: 2rem;
        border: none;
        cursor: pointer;
        transition: all var(--transition-base);
    }

    .btn-submit:hover {
        background: var(--color-white) !important;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--accent-primary) !important; /* Couleur Pêche pour la lisibilité */
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
        .tech-section {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <h1>Modifier la ressource</h1>

    <form class="form" method="POST" action="{{ route('admin.ressources.update', $ressource) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="categorie_id" class="form-label">Catégorie</label>
            <select id="categorie_id" name="categorie_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('categorie_id', $ressource->categorie_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="manager_id" class="form-label">Responsable Technique (optionnel)</label>
            <select id="manager_id" name="manager_id">
                <option value="">Aucun</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}"
                        {{ old('manager_id', $ressource->manager_id) == $manager->id ? 'selected' : '' }}>
                        {{ $manager->nom }} {{ $manager->prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="nom"
                   value="{{ old('nom', $ressource->nom) }}" required maxlength="120">
        </div>

        <div class="form-group">
            <label for="code_inv" class="form-label">Code inventaire</label>
            <input type="text" id="code_inv" name="code_inv"
                   value="{{ old('code_inv', $ressource->code_inv) }}" maxlength="60">
        </div>

        <div class="form-group">
            <label for="etat" class="form-label">État</label>
            <select id="etat" name="etat" required>
                <option value="available"   {{ old('etat', $ressource->etat) == 'available' ? 'selected' : '' }}>Disponible</option>
                <option value="maintenance" {{ old('etat', $ressource->etat) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="disabled"    {{ old('etat', $ressource->etat) == 'disabled' ? 'selected' : '' }}>Désactivée</option>
            </select>
        </div>

        <div class="form-group">
            <label for="actif" class="form-label">Actif</label>
            <select id="actif" name="actif" required>
                <option value="1" {{ old('actif', $ressource->actif) == 1 ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ old('actif', $ressource->actif) == 0 ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <div class="form-group">
            <label for="emplacement" class="form-label">Emplacement</label>
            <input type="text" id="emplacement" name="emplacement"
                   value="{{ old('emplacement', $ressource->emplacement) }}" maxlength="120">
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description">{{ old('description', $ressource->description) }}</textarea>
        </div>

        <div class="tech-section">
            <div class="tech-title">⚙️ Caractéristiques Techniques</div>
            
            <div class="form-group">
                <label for="cpu" class="form-label">CPU</label>
                <input type="text" id="cpu" name="cpu" value="{{ old('cpu', $ressource->cpu) }}" placeholder="ex: 8 Cores">
            </div>

            <div class="form-group">
                <label for="ram" class="form-label">RAM</label>
                <input type="text" id="ram" name="ram" value="{{ old('ram', $ressource->ram) }}" placeholder="ex: 16 GB">
            </div>

            <div class="form-group">
                <label for="os" class="form-label">Système d'exploitation (OS)</label>
                <input type="text" id="os" name="os" value="{{ old('os', $ressource->os) }}" placeholder="ex: Ubuntu 22.04">
            </div>

            <div class="form-group">
                <label for="bande_passante" class="form-label">Bande passante</label>
                <input type="text" id="bande_passante" name="bande_passante" value="{{ old('bande_passante', $ressource->bande_passante) }}" placeholder="ex: 1 Gbps">
            </div>

            <div class="form-group">
                <label for="capacite" class="form-label">Capacité / Stockage</label>
                <input type="text" id="capacite" name="capacite" value="{{ old('capacite', $ressource->capacite) }}" placeholder="ex: 500 GB">
            </div>

            <div class="form-group">
                <label for="type_stockage" class="form-label">Type de stockage</label>
                <input type="text" id="type_stockage" name="type_stockage" value="{{ old('type_stockage', $ressource->type_stockage) }}" placeholder="ex: SSD NVMe">
            </div>
        </div>

        <button type="submit" class="btn-submit">Enregistrer les modifications</button>
    </form>
@endsection
