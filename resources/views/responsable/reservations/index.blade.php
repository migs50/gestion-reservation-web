@extends('layouts.app')

@section('title', 'Mes réservations de ressources')

@section('content')
<div class="container">
    <h1>Réservations de mes ressources</h1>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Ressource</th>
                <th>Demandeur</th>
                <th>Période</th>
                <th>Statut</th>
                <th>Note décision</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($reservations as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>{{ $reservation->ressource->nom }}</td>
                <td>{{ $reservation->demandeur->nom }}</td>
                <td>
                    {{ $reservation->debut }}<br>
                    {{ $reservation->fin }}
                </td>
                <td>{{ $reservation->statut }}</td>
                <td>{{ $reservation->note_decision }}</td>
                <td>
                    @if($reservation->statut === 'pending')
                        <form action="{{ route('responsable.reservations.approve', $reservation) }}" method="POST" style="display:inline-block">
                            @csrf
                            <input type="text" name="note_decision" placeholder="Justification" required>
                            <button type="submit" class="btn btn-success btn-sm">Accepter</button>
                        </form>

                        <form action="{{ route('responsable.reservations.refuse', $reservation) }}" method="POST" style="display:inline-block">
                            @csrf
                            <input type="text" name="note_decision" placeholder="Justification" required>
                            <button type="submit" class="btn btn-danger btn-sm">Refuser</button>
                        </form>
                    @else
                        {{-- déjà traité --}}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $reservations->links() }}
</div>
@endsection
