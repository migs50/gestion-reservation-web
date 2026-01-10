@extends('layouts.app')

@section('title', 'Nouvelle réservation')

@section('content')

<style>
/* Fond global */
body {
    background: #f5f7fb;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* Conteneur */
.container {
    max-width: 800px;
    margin: 40px auto;
    padding: 24px 28px;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
}

/* Titre */
.container h1 {
    font-size: 2rem;
    margin-bottom: 1.2rem;
    color: #111827;
}

/* Texte ressource */
.container p {
    margin-bottom: 1.5rem;
    color: #374151;
}

/* Alert erreur */
.alert.alert-danger {
    background: #fee2e2;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    color: #b91c1c;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

/* Groupes de champs */
.mb-3 {
    margin-bottom: 1.1rem;
}

/* Label */
.form-label {
    display: block;
    margin-bottom: 0.35rem;
    font-size: 0.9rem;
    font-weight: 600;
    color: #374151;
}

/* Inputs & textarea */
.form-control {
    width: 100%;
    padding: 0.55rem 0.8rem;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    font-size: 0.95rem;
    color: #111827;
    background: #f9fafb;
    transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #6366f1;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.18);
}

/* Bouton primaire */
.btn.btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.65rem 1.8rem;
    border-radius: 999px;
    border: none;
    font-weight: 600;
    letter-spacing: 0.02em;
    background: linear-gradient(135deg, #4f46e5, #111827);
    color: #ffffff;
    cursor: pointer;
    transition: transform 0.12s ease, box-shadow 0.12s ease, background 0.2s ease;
}

.btn.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 12px 25px rgba(15, 23, 42, 0.25);
    background: linear-gradient(135deg, #4338ca, #0f172a);
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        margin: 16px;
        padding: 18px 16px;
    }

    .container h1 {
        font-size: 1.6rem;
    }
}
</style>


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