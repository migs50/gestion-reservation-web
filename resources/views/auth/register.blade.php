@extends('layouts.app')

@section('title', 'Demande de compte')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1>Demande d'ouverture de compte</h1>
        <p class="subtitle">Remplissez ce formulaire pour demander un accès au système de gestion des ressources.</p>

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="nom_complet">Nom complet *</label>
                <input type="text" id="nom_complet" name="nom_complet" value="{{ old('nom_complet') }}" required maxlength="150">
            </div>

            <div class="form-group">
                <label for="email">Adresse email *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required maxlength="191">
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone *</label>
                <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}" required maxlength="30">
            </div>

            <div class="form-group">
                <label for="type_demande">Type de compte demandé *</label>
                <select id="type_demande" name="type_demande" required>
                    <option value="">-- Sélectionner --</option>
                    <option value="Interne" {{ old('type_demande') == 'Interne' ? 'selected' : '' }}>Utilisateur Interne (Ingénieur/Enseignant/Doctorant)</option>
                    <option value="Responsable" {{ old('type_demande') == 'Responsable' ? 'selected' : '' }}>Responsable Technique</option>
                </select>
            </div>

            <div class="form-group">
                <label for="justification">Justification de la demande *</label>
                <textarea id="justification" name="justification" rows="5" required>{{ old('justification') }}</textarea>
                <small>Expliquez pourquoi vous avez besoin d'un accès aux ressources du Data Center.</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Soumettre la demande</button>
                <a href="{{ route('login') }}" class="btn btn-secondary">Retour</a>
            </div>
        </form>

        <div class="auth-footer">
            <p>Votre demande sera examinée par un administrateur. Vous recevrez un email une fois votre compte activé.</p>
        </div>
    </div>
</div>
@endsection
