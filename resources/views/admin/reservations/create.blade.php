@extends('layouts.admin')

@section('title', 'Nouvelle réservation')

@section('content')
    <h1>Nouvelle réservation</h1>

<form action="{{ route('reservations.store') }}" method="POST" class="form-card">
    @csrf

    <label for="ressource_id">Ressource</label>
    <select name="ressource_id" id="ressource_id" required>
        @foreach($ressources as $ressource)
            <option value="{{ $ressource->id }}">
                {{ $ressource->nom }}
            </option>
        @endforeach
    </select>

    <label for="user_id">Demandeur</label>
    <select name="user_id" id="user_id" required>
        @foreach($users as $user)
            <option value="{{ $user->id }}">
                {{ $user->nom }} {{ $user->prenom }}
            </option>
        @endforeach
    </select>

    <label for="debut">Date début</label>
    <input type="datetime-local" name="debut" id="debut" required>

    <label for="fin">Date fin</label>
    <input type="datetime-local" name="fin" id="fin" required>

    <label for="justification">Justification</label>
    <textarea name="justification" id="justification" required></textarea>

    <button type="submit">Enregistrer</button>
</form>
@endsection