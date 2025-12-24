@extends('layouts.guest')

@section('content')
<h1>{{ $ressource->nom }}</h1>

<a href="{{ route('reservations.create', $ressource) }}">Réserver cette ressource</a>
@endsection