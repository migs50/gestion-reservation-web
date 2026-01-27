@extends('layouts.admin')

@section('title', 'Modifier Utilisateur')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div class="card">
    <div class="card-header">
        <h3>Modifier l'utilisateur : {{ $user->nom }} {{ $user->prenom }}</h3>
    </div>
    
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label style="color: #000000ff;">Nom & Prénom</label>
            <input type="text" value="{{ $user->nom }} {{ $user->prenom }}" disabled style="background: #000000ff;">
        </div>

        <div class="form-group">
            <label style="color: #000000ff;">Email</label>
            <input type="text" value="{{ $user->email }}" disabled style="background: #000000ff;">
        </div>
 
        <div class="form-group">
            <label for="role_id" style="color: #000000ff;">Rôle</label>
            <select name="role_id" id="role_id" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                        {{ ucfirst($role->nom) }}
                    </option>
                @endforeach
            </select>
            @error('role_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
