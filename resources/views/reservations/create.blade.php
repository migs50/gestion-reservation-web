@extends('layouts.app')

@section('title', 'Nouvelle réservation')

@section('content')
<div class="container" style="max-width: 800px; margin: 40px auto;">
@if($errors->has('debut'))
    <div class="alert alert-danger">
        {{ $errors->first('debut') }}
    </div>
@endif
    <h1>Nouvelle réservation</h1>

    <p>Ressource : <strong>{{ $ressource->nom }}</strong></p>

    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf

        <input type="hidden" name="ressource_id" value="{{ $ressource->id }}">

              <div class="mb-3">
                  <label for="debut" class="form-label">Date de début</label>
                  <input type="datetime-local" name="debut" id="debut"
                        class="form-control" required>
              </div>

              <div class="mb-3">
                  <label for="fin" class="form-label">Date de fin</label>
                  <input type="datetime-local" name="fin" id="fin"
                        class="form-control" required>
              </div>

              <div class="mb-3">
                  <label for="justification" class="form-label">Motif / description</label>
                  <textarea name="justification" id="justification"
                            class="form-control" rows="3" required></textarea>
              </div>


        <button type="submit" class="btn btn-primary">
            Envoyer la demande de réservation
        </button>
    </form>
</div>


@endsection
