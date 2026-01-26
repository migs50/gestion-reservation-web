@extends('layouts.app')

@section('title', 'Signaler un incident')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 30px;">
        <h1>Signaler un problème technique</h1>
        <p style="color: #636e72;">Décrivez le problème rencontré avec le plus de précisions possibles.</p>
    </div>

    <div class="glass-card" style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        <form action="{{ route('user.incidents.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">Titre du problème</label>
                <input type="text" name="titre" value="{{ old('titre') }}" required 
                       style="width: 100%; padding: 12px; border: 2px solid #ecf0f1; border-radius: 10px;"
                       placeholder="Ex: Écran noir sur le serveur X, Erreur de connexion...">
                @error('titre') <p style="color: #e74c3c; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">Ressource concernée (optionnel)</label>
                <select name="ressource_id" style="width: 100%; padding: 12px; border: 2px solid #ecf0f1; border-radius: 10px;">
                    <option value="">-- Problème général --</option>
                    @foreach($ressources as $ressource)
                        <option value="{{ $ressource->id }}" {{ old('ressource_id') == $ressource->id ? 'selected' : '' }}>
                            {{ $ressource->nom }} ({{ $ressource->categorie->nom ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 700; margin-bottom: 8px;">Description détaillée</label>
                <textarea name="description" rows="6" required 
                          style="width: 100%; padding: 12px; border: 2px solid #ecf0f1; border-radius: 10px;"
                          placeholder="Décrivez les étapes pour reproduire le problème, les messages d'erreur affichés..."></textarea>
                @error('description') <p style="color: #e74c3c; font-size: 13px;">{{ $message }}</p> @enderror
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit" class="btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 30px; border-radius: 10px; font-weight: 700; cursor: pointer;">
                    Envoyer le signalement
                </button>
                <a href="{{ route('user.incidents.index') }}" style="padding: 14px 30px; color: #636e72; text-decoration: none; font-weight: 600;">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
