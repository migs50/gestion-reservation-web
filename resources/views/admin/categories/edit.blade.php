@extends('layouts.admin')

@section('title', 'Modifier la Catégorie')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div class="card">
    <div class="card-header">
        <h3>Modifier : {{ $categorie->nom }}</h3>
    </div>

   <form action="{{ route('admin.categories.update', $categorie->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nom">Nom de la catégorie</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $categorie->nom) }}" required>
            @error('nom')
                <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $categorie->description) }}</textarea>
            @error('description')
                <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.categories.index') }}" class="btn" style="background: #95a5a6; color: white;">Annuler</a>
        </div>
    </form>
</div>
@endsection
