@extends('layouts.admin')

@section('title', 'Nouvel Utilisateur')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div class="card">
    <div class="card-header">
        <h3>➕ Ajouter un nouvel utilisateur</h3>
    </div>
    
    <form action="{{ route('admin.users.store') }}" method="POST" class="form">
        @csrf
        
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required>
            @error('nom') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required>
            @error('prenom') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="role_id">Rôle</label>
            <select name="role_id" id="role_id" required>
                <option value="">Sélectionner un rôle</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ ucfirst($role->nom) }}
                    </option>
                @endforeach
            </select>
            @error('role_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="statut">Statut</label>
            <select name="statut" id="statut" required>
                <option value="active" {{ old('statut') == 'active' ? 'selected' : '' }}>Actif</option>
                <option value="inactive" {{ old('statut') == 'inactive' ? 'selected' : '' }}>Inactif</option>
            </select>
            @error('statut') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Créer l'utilisateur</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
