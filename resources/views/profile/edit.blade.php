@extends('layouts.app')

@section('title', 'Modifier le profil')

@section('content')
<div class="profile-container">
    <div class="page-header">
        <h1>Modifier le profil</h1>
        <a href="{{ route('profile') }}" class="btn btn-secondary">Retour</a>
    </div>

    <div class="profile-content">
        <div class="profile-card">
            <h2>Informations personnelles</h2>

            @if($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $user->nom) }}" required maxlength="80">
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}" required maxlength="80">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required maxlength="191">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>

        <div class="profile-card">
            <h2>Changer le mot de passe</h2>

            <form method="POST" action="{{ route('profile.password') }}" class="profile-form">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="current_password">Mot de passe actuel</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password" id="password" name="password" required minlength="8">
                    <small>Minimum 8 caractères</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
