@extends('layouts.admin')

@section('title', 'Modifier la Maintenance')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div class="card">
    <div class="card-header">
        <h3>Modifier la planification</h3>
    </div>

    <form action="{{ route('admin.maintenances.update', $maintenance) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="ressource_id">Ressource concernée</label>
            <select name="ressource_id" id="ressource_id" class="form-control" required>
                @foreach($ressources as $ressource)
                    <option value="{{ $ressource->id }}" {{ $maintenance->ressource_id == $ressource->id ? 'selected' : '' }}>
                        {{ $ressource->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="type">Type d'indisponibilité</label>
            <select name="type" id="type" class="form-control" required>
                <option value="maintenance" {{ $maintenance->type == 'maintenance' ? 'selected' : '' }}>Maintenance préventive</option>
                <option value="repair" {{ $maintenance->type == 'repair' ? 'selected' : '' }}>Réparation curative</option>
                <option value="inventory" {{ $maintenance->type == 'inventory' ? 'selected' : '' }}>Inventaire / Audit</option>
                <option value="other" {{ $maintenance->type == 'other' ? 'selected' : '' }}>Autre / Exceptionnel</option>
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="debut">Date de début</label>
                <input type="datetime-local" name="debut" id="debut" class="form-control" value="{{ $maintenance->debut->format('Y-m-d\TH:i') }}" required>
            </div>
            <div class="form-group">
                <label for="fin">Date de fin</label>
                <input type="datetime-local" name="fin" id="fin" class="form-control" value="{{ $maintenance->fin->format('Y-m-d\TH:i') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label for="raison">Raison / Détails</label>
            <textarea name="raison" id="raison" class="form-control" rows="4" required>{{ $maintenance->raison }}</textarea>
        </div>

        <div class="form-group">
            <label for="actif">Statut</label>
            <select name="actif" id="actif" class="form-control">
                <option value="1" {{ $maintenance->actif ? 'selected' : '' }}>Actif</option>
                <option value="0" {{ !$maintenance->actif ? 'selected' : '' }}>Annulé / Inactif</option>
            </select>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.maintenances.index') }}" class="btn" style="background: #95a5a6; color: white;">Annuler</a>
        </div>
    </form>
</div>
@endsection
