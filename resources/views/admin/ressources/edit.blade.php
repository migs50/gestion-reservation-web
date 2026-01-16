@extends('layouts.admin')

@section('title', 'Modifier ressource')

@push('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    {{-- tu peux réutiliser exactement le même CSS que dans create --}}
@endpush

@section('content')
    <h1>Modifier la ressource</h1>

    <form class="form" method="POST" action="{{ route('admin.ressources.update', $ressource) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="categorie_id">Catégorie</label>
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
            <label for="manager_id">Manager (optionnel)</label>
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
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom"
                   value="{{ old('nom', $ressource->nom) }}" required maxlength="120">
        </div>

        <div class="form-group">
            <label for="code_inv">Code inventaire</label>
            <input type="text" id="code_inv" name="code_inv"
                   value="{{ old('code_inv', $ressource->code_inv) }}" maxlength="60">
        </div>

        <div class="form-group">
            <label for="etat">État</label>
            <select id="etat" name="etat" required>
                <option value="available"   {{ old('etat', $ressource->etat) == 'available' ? 'selected' : '' }}>Disponible</option>
                <option value="maintenance" {{ old('etat', $ressource->etat) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="disabled"    {{ old('etat', $ressource->etat) == 'disabled' ? 'selected' : '' }}>Désactivée</option>
            </select>
        </div>

        <div class="form-group">
            <label for="actif">Actif</label>
            <select id="actif" name="actif" required>
                <option value="1" {{ old('actif', $ressource->actif) == 1 ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ old('actif', $ressource->actif) == 0 ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <div class="form-group">
            <label for="emplacement">Emplacement</label>
            <input type="text" id="emplacement" name="emplacement"
                   value="{{ old('emplacement', $ressource->emplacement) }}" maxlength="120">
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description">{{ old('description', $ressource->description) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 12px; border: 1px dashed #d1d5db;">
            <div style="grid-column: span 2; font-weight: bold; margin-bottom: 10px; color: #4b5563;">⚙️ Caractéristiques Techniques</div>
            
            <div class="form-group">
                <label for="cpu">CPU</label>
                <input type="text" id="cpu" name="cpu" value="{{ old('cpu', $ressource->cpu) }}" placeholder="ex: 8 Cores">
            </div>

            <div class="form-group">
                <label for="ram">RAM</label>
                <input type="text" id="ram" name="ram" value="{{ old('ram', $ressource->ram) }}" placeholder="ex: 16 GB">
            </div>

            <div class="form-group">
                <label for="os">Système d'exploitation (OS)</label>
                <input type="text" id="os" name="os" value="{{ old('os', $ressource->os) }}" placeholder="ex: Ubuntu 22.04">
            </div>

            <div class="form-group">
                <label for="bande_passante">Bande passante</label>
                <input type="text" id="bande_passante" name="bande_passante" value="{{ old('bande_passante', $ressource->bande_passante) }}" placeholder="ex: 1 Gbps">
            </div>

            <div class="form-group">
                <label for="capacite">Capacité / Stockage</label>
                <input type="text" id="capacite" name="capacite" value="{{ old('capacite', $ressource->capacite) }}" placeholder="ex: 500 GB">
            </div>

            <div class="form-group">
                <label for="type_stockage">Type de stockage</label>
                <input type="text" id="type_stockage" name="type_stockage" value="{{ old('type_stockage', $ressource->type_stockage) }}" placeholder="ex: SSD NVMe">
            </div>
        </div>

        <button type="submit" class="btn">Enregistrer</button>
    </form>
@endsection
