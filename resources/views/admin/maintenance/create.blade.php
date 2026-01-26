@extends('layouts.admin')

@section('title', 'Planifier une Maintenance')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div class="card">
    <div class="card-header">
        <h3>Nouvelle Période d'Indisponibilité</h3>
    </div>

    <form action="{{ route('admin.maintenance.store') }}" method="POST" class="form">
        @csrf

        <div class="form-group">
            <label for="ressource_id">Ressource concernée</label>
            <select name="ressource_id" id="ressource_id" class="form-control" required>
                <option value="">-- Sélectionner une ressource --</option>
                @foreach($ressources as $ressource)
                    <option value="{{ $ressource->id }}">{{ $ressource->nom }} ({{ $ressource->code_inv }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="type">Type d'indisponibilité</label>
            <select name="type" id="type" class="form-control" required>
                <option value="maintenance">Maintenance préventive</option>
                <option value="repair">Réparation curative</option>
                <option value="inventory">Inventaire / Audit</option>
                <option value="other">Autre / Exceptionnel</option>
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="debut">Date de début</label>
                <input type="datetime-local" name="debut" id="debut" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fin">Date de fin</label>
                <input type="datetime-local" name="fin" id="fin" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <label for="raison">Raison / Détails</label>
            <textarea name="raison" id="raison" class="form-control" rows="4" placeholder="Expliquez la raison de cette indisponibilité..." required></textarea>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Planifier</button>
            <a href="{{ route('admin.maintenance.index') }}" class="btn" style="background: #95a5a6; color: white;">Annuler</a>
        </div>
    </form>
</div>
@endsection
