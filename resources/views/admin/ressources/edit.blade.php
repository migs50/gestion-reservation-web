@extends('layouts.admin')

@section('title', 'Modifier ressource')

@push('style')
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

        <button type="submit" class="btn">Enregistrer</button>
    </form>
@endsection
