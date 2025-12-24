<form method="POST" action="{{ route('reservations.store') }}">
    @csrf
    <input type="hidden" name="ressource_id" value="{{ $ressource->id }}">

    <label>Début</label>
    <input type="datetime-local" name="debut" value="{{ old('debut') }}">

    <label>Fin</label>
    <input type="datetime-local" name="fin" value="{{ old('fin') }}">

    <label>Justification</label>
    <textarea name="justification">{{ old('justification') }}</textarea>

    <button type="submit">Envoyer la demande</button>
</form>

