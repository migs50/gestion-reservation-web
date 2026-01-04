@extends('layouts.app')

@section('title', 'Mes réservations')

@section('content')
    <h1>Mes réservations</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ressource</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $reservation)
                <tr>
                    <td>#{{ $reservation->id }}</td>
                    <td>{{ $reservation->affectations->first()?->ressource->nom ?? 'N/A' }}</td>
                    <td>{{ $reservation->debut?->format('d/m/Y H:i') }}</td>
                    <td>{{ $reservation->fin?->format('d/m/Y H:i') }}</td>
                    <td>{{ $reservation->statut }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Aucune réservation.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $reservations->links() }}
@endsection
