@extends('layouts.auth')

@section('title', 'Mot de passe oublié')

@section('subtitle', 'Réinitialisation de mot de passe')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

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

    .info-text {
        background: #e7f3ff;
        color: #0c5460;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        line-height: 1.6;
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

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
</style>

<div class="alert alert-success" id="successAlert" style="display: none;">
    <strong>✅ Email envoyé !</strong><br>
    Un lien de réinitialisation a été envoyé à votre adresse email.
</div>

<div class="info-text">
    <strong>ℹ️ Comment ça fonctionne ?</strong><br>
    Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe. 
    Le lien sera valide pendant 60 minutes.
</div>

<form id="forgotPasswordForm" onsubmit="handleForgotPassword(event)">
    @csrf
    <div class="form-group">
        <label for="email">Adresse email</label>
        <input type="email" id="email" name="email" placeholder="votre.email@example.com" required>
    </div>

    <button type="submit" class="btn">Envoyer le lien de réinitialisation</button>
</form>

<script>
    function handleForgotPassword(event) {
        event.preventDefault();
        
        const email = document.getElementById('email').value;
        
        if (email) {
            // Afficher le message de succès
            document.getElementById('successAlert').style.display = 'block';
            document.getElementById('forgotPasswordForm').style.display = 'none';
            
            // Redirection après 3 secondes
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 3000);
        }
        
        return false;
    }
</script>
@endsection
