@extends('layouts.app')

@section('title', 'Connexion')

@section('subtitle', 'Connectez-vous à votre compte')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">


<!-- Alert pour démonstration -->
<div class="alert alert-error" id="loginAlert" style="display: none;">
    <strong>❌ Erreur de connexion</strong><br>
    Email ou mot de passe incorrect.
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="email">Adresse email</label>
        <input type="email" id="email" name="email" placeholder="votre.email@example.com" required>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
        <div class="forgot-link">
            <a href="{{ route('secret.email') }}">Mot de passe oublié ?</a>
        </div>
    </div>

    <button type="submit" class="btn">Se connecter</button>
</form>



@endsection
@section('footer')
    Vous avez déjà un compte ? 
    <a href="{{ route('login') }}">Se connecter</a>
@endsection
