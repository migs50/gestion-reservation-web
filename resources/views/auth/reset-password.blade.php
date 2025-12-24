@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <h1>Réinitialiser le mot de passe</h1>

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" id="password" name="password" required minlength="8">
                <small>Minimum 8 caractères</small>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Réinitialiser</button>
            </div>
        </form>
    </div>
</div>
@endsection
