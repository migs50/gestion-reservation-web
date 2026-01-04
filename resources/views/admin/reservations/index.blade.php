@extends('layouts.admin')

@section('title', 'Réservations')

@section('content')
    <h1>Liste des réservations</h1>

    <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary">
        Nouvelle réservation
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Demandeur</th>
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
                    <td>{{ $reservation->demandeur->nom ?? 'N/A' }} {{ $reservation->demandeur->prenom ?? '' }}</td>
                    <td>{{ $reservation->ressource->nom ?? 'N/A' }}</td>
                    <td>{{ $reservation->debut?->format('d/m/Y H:i') }}</td>
                    <td>{{ $reservation->fin?->format('d/m/Y H:i') }}</td>
                    <td>{{ $reservation->statut }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Aucune réservation trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $reservations->links() }}
@endsection
