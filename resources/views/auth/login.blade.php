@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1>Connexion</h1>

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group checkbox-group">
                <label>
                    <input type="checkbox" name="remember">
                    <span>Se souvenir de moi</span>
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Se connecter</button>
                <a href="{{ route('password.request') }}" class="link">Mot de passe oublié?</a>
            </div>
        </form>

        <div class="auth-footer">
            <p>Pas encore de compte? <a href="{{ route('register') }}">Demander un accès</a></p>
        </div>
    </div>
</div>
@endsection
