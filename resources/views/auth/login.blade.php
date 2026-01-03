@extends('layouts.auth')

@section('title', 'Connexion')

@section('subtitle', 'Connectez-vous à votre compte')

@section('content')
<style>
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 500;
        font-size: 14px;
    }

    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .forgot-link {
        text-align: right;
        margin-top: 8px;
    }

    .forgot-link a {
        color: #667eea;
        font-size: 13px;
        text-decoration: none;
    }

    .forgot-link a:hover {
        text-decoration: underline;
    }

    .btn {
        display: block;
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease;
        margin-top: 10px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .alert {
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<!-- Alert pour démonstration -->
<div class="alert alert-error" id="loginAlert" style="display: none;">
    <strong>❌ Erreur de connexion</strong><br>
    Email ou mot de passe incorrect.
</div>

<form id="loginForm" onsubmit="handleLogin(event)">
        @csrf
    <div class="form-group">
        <label for="email">Adresse email</label>
        <input type="email" id="email" name="email" placeholder="votre.email@example.com" required>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
        <div class="forgot-link">
            <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
        </div>
    </div>

    <button type="submit" class="btn">Se connecter</button>
</form>

<script>
    function handleLogin(event) {
        event.preventDefault();
        
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Simulation de connexion
        if (email && password) {
            // Redirection simulée vers le dashboard utilisateur
            window.location.href = "{{ route('user.dashboard') }}";
        } else {
            // Afficher l'erreur
            document.getElementById('loginAlert').style.display = 'block';
        }
        
        return false;
    }
</script>
@endsection
@section('footer')
    Vous avez déjà un compte ? 
    <a href="{{ route('login') }}">Se connecter</a>
@endsection
