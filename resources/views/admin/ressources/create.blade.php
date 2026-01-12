@extends('layouts.admin')

@section('title', 'Nouvelle ressource')

@push('style')
<style>
/* Fond global de la page admin */
main .content,
.admin-main,
body {
    background: #f5f7fb;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* Titre */
h1 {
    font-size: 2rem;
    margin: 0 0 1.5rem;
    color: #111827;
}

/* Carte formulaire */
form.form {
    max-width: 640px;
    margin: 1.5rem auto;
    padding: 2rem 2.4rem;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
}

/* Groupes de champs */
.form-group {
    margin-bottom: 1.25rem;
}

/* Label */
.form-group label {
    display: block;
    margin-bottom: 0.35rem;
    font-size: 0.9rem;
    font-weight: 600;
    color: #374151;
}

/* Inputs, selects, textarea */
.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.55rem 0.8rem;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    font-size: 0.95rem;
    color: #111827;
    background: #f9fafb;
    transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease, transform 0.1s ease;
}

/* Textarea */
.form-group textarea {
    min-height: 110px;
    resize: vertical;
}

/* Focus */
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #6366f1;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.20);
    transform: translateY(-1px);
}

/* Bouton */
form.form .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.65rem 1.8rem;
    border-radius: 999px;
    border: none;
    font-weight: 600;
    letter-spacing: 0.02em;
    background: linear-gradient(135deg, #111827, #4b5563);
    color: #ffffff !important;
    cursor: pointer;
    transition: transform 0.12s ease, box-shadow 0.12s ease, background 0.2s ease;
    margin-top: 0.5rem;
}

form.form .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 12px 25px rgba(15, 23, 42, 0.25);
    background: linear-gradient(135deg, #0f172a, #374151);
}

form.form .btn:active {
    transform: translateY(0);
    box-shadow: 0 6px 12px rgba(15, 23, 42, 0.2);
}

/* Responsive petit écran */
@media (max-width: 768px) {
    form.form {
        margin: 1rem;
        padding: 1.4rem 1.2rem;
    }

    h1 {
        font-size: 1.6rem;
    }
}
</style>
@endpush

@section('content')
    <h1>Nouvelle ressource</h1>

    <form class="form" method="POST" action="{{ route('admin.ressources.store') }}">
        @csrf

        <div class="form-group">
            <label for="categorie_id">Catégorie</label>
            <select id="categorie_id" name="categorie_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('categorie_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="manager_id">Manager (optionnel)</label>
            <select id="manager_id" name="manager_id">
                <option value="">Aucun</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                        {{ $manager->nom }} {{ $manager->prenom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required maxlength="120">
        </div>

        <div class="form-group">
            <label for="code_inv">Code inventaire</label>
            <input type="text" id="code_inv" name="code_inv" value="{{ old('code_inv') }}" maxlength="60">
        </div>

        <div class="form-group">
            <label for="etat">État</label>
            <select id="etat" name="etat" required>
                <option value="available"   {{ old('etat') == 'available' ? 'selected' : '' }}>Disponible</option>
                <option value="maintenance" {{ old('etat') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="disabled"    {{ old('etat') == 'disabled' ? 'selected' : '' }}>Désactivée</option>
            </select>
        </div>

        <div class="form-group">
            <label for="actif">Actif</label>
            <select id="actif" name="actif" required>
                <option value="1" {{ old('actif', 1) == 1 ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ old('actif', 1) == 0 ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <div class="form-group">
            <label for="emplacement">Emplacement</label>
            <input type="text" id="emplacement" name="emplacement"
                   value="{{ old('emplacement') }}" maxlength="120">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 12px; border: 1px dashed #d1d5db;">
            <div style="grid-column: span 2; font-weight: bold; margin-bottom: 10px; color: #4b5563;">⚙️ Caractéristiques Techniques</div>
            
            <div class="form-group">
                <label for="cpu">CPU</label>
                <input type="text" id="cpu" name="cpu" value="{{ old('cpu') }}" placeholder="ex: 8 Cores">
            </div>

            <div class="form-group">
                <label for="ram">RAM</label>
                <input type="text" id="ram" name="ram" value="{{ old('ram') }}" placeholder="ex: 16 GB">
            </div>

            <div class="form-group">
                <label for="os">Système d'exploitation (OS)</label>
                <input type="text" id="os" name="os" value="{{ old('os') }}" placeholder="ex: Ubuntu 22.04">
            </div>

            <div class="form-group">
                <label for="bande_passante">Bande passante</label>
                <input type="text" id="bande_passante" name="bande_passante" value="{{ old('bande_passante') }}" placeholder="ex: 1 Gbps">
            </div>

            <div class="form-group">
                <label for="capacite">Capacité / Stockage</label>
                <input type="text" id="capacite" name="capacite" value="{{ old('capacite') }}" placeholder="ex: 500 GB">
            </div>

            <div class="form-group">
                <label for="type_stockage">Type de stockage</label>
                <input type="text" id="type_stockage" name="type_stockage" value="{{ old('type_stockage') }}" placeholder="ex: SSD NVMe">
            </div>
        </div>

        <button type="submit" class="btn">Enregistrer</button>
    </form>
@endsection
