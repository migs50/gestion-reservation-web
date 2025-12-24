@foreach($reservations as $reservation)
    <tr>
        <td>{{ $reservation->ressource->nom }}</td>
        <td>{{ $reservation->debut }} → {{ $reservation->fin }}</td>
        <td>{{ $reservation->statut }}</td>
    </tr>
@endforeach