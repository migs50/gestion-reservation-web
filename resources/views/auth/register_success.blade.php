@extends('layouts.auth')

@section('content')
    <h2>Demande envoyée</h2>
    <p>Votre demande de création de compte a été envoyée avec succès.</p>
    <p>Elle est actuellement <strong>en attente</strong> de validation par l'administrateur.</p>
    <p style="margin-top: 10px;">
    Vous recevrez un email lorsque votre demande sera validée.
    En attendant, vous pouvez réessayer de vous connecter plus tard avec votre adresse email.
</p>

<a href="{{ route('login') }}" class="btn btn-primary mt-4">
    Retour à la page de connexion
</a>

@endsection
