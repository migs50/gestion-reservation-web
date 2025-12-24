@extends('layouts.guest')

@section('content')
@foreach($ressources as $ressource)
    <div>
        {{ $ressource->nom }}
        <a href="{{ route('ressources.show', $ressource) }}">Voir</a>
        <a href="{{ route('reservations.create', $ressource) }}">Réserver</a>
    </div>
@endforeach
@endsection