@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1>Mot de passe oublié</h1>
        <p class="subtitle">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Envoyer le lien</button>
                <a href="{{ route('login') }}" class="link">Retour à la connexion</a>
            </div>
        </form>
    </div>
</div>
@endsection
