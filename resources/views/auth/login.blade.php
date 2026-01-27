@extends('layouts.app')

@section('title', 'Connexion')

@section('subtitle', 'Connectez-vous à votre compte')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">


@if($errors->any())
    <div class="alert alert-error">
        <strong>Erreur de connexion</strong><br>
        @foreach($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="email">Adresse email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="votre.email@example.com" required autofocus>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
        <div class="forgot-link">
            <a href="{{ route('secret.email') }}">Mot de passe oublié ?</a>
        </div>
    </div>

    <div class="form-group checkbox-group" style="margin-bottom: 20px;">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember" style="display: inline; cursor: pointer;">Se souvenir de moi</label>
    </div>

    <button type="submit" class="btn">Se connecter</button>
</form>



@endsection
@section('footer')
    Vous avez déjà un compte ? 
    <a href="{{ route('login') }}">Se connecter</a>
@endsection
