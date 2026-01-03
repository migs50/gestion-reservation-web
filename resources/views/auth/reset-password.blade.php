@extends('layouts.auth')

@section('title', 'Réinitialisation du mot de passe')

@section('subtitle', 'Créez un nouveau mot de passe')

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

    .form-group small {
        display: block;
        margin-top: 5px;
        color: #7f8c8d;
        font-size: 12px;
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

    .password-strength {
        margin-top: 8px;
        font-size: 12px;
    }

    .strength-bar {
        height: 4px;
        background: #e0e0e0;
        border-radius: 2px;
        margin-top: 5px;
        overflow: hidden;
    }

    .strength-bar-inner {
        height: 100%;
        width: 0%;
        transition: width 0.3s ease, background 0.3s ease;
    }

    .strength-weak { background: #e74c3c; width: 33%; }
    .strength-medium { background: #f39c12; width: 66%; }
    .strength-strong { background: #2ecc71; width: 100%; }

    .requirements {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
    }

    .requirements h4 {
        font-size: 14px;
        margin-bottom: 10px;
        color: #2c3e50;
    }

    .requirements ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .requirements li {
        font-size: 13px;
        color: #7f8c8d;
        margin-bottom: 5px;
        padding-left: 20px;
        position: relative;
    }

    .requirements li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: #2ecc71;
    }
</style>

<form id="resetPasswordForm" onsubmit="handleResetPassword(event)">
    @csrf
    <input type="hidden" name="token" value="{{ request()->route('token') }}">
    
    <div class="form-group">
        <label for="email">Adresse email</label>
        <input type="email" id="email" name="email" placeholder="votre.email@example.com" required readonly value="{{ request()->email }}">
    </div>

    <div class="form-group">
        <label for="password">Nouveau mot de passe</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required oninput="checkPasswordStrength()">
        <div class="password-strength">
            <div id="strengthText">Force du mot de passe : <span id="strengthLabel">Faible</span></div>
            <div class="strength-bar">
                <div id="strengthBar" class="strength-bar-inner"></div>
            </div>
        </div>
        <small>Minimum 8 caractères</small>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
    </div>

    <div class="requirements">
        <h4>Exigences du mot de passe :</h4>
        <ul>
            <li>Au moins 8 caractères</li>
            <li>Au moins une lettre majuscule</li>
            <li>Au moins une lettre minuscule</li>
            <li>Au moins un chiffre</li>
            <li>Au moins un caractère spécial (recommandé)</li>
        </ul>
    </div>

    <button type="submit" class="btn">Réinitialiser le mot de passe</button>
</form>

<script>
    function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthBar = document.getElementById('strengthBar');
        const strengthLabel = document.getElementById('strengthLabel');
        
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;
        
        strengthBar.className = 'strength-bar-inner';
        
        if (strength <= 2) {
            strengthBar.classList.add('strength-weak');
            strengthLabel.textContent = 'Faible';
        } else if (strength === 3) {
            strengthBar.classList.add('strength-medium');
            strengthLabel.textContent = 'Moyen';
        } else {
            strengthBar.classList.add('strength-strong');
            strengthLabel.textContent = 'Fort';
        }
    }

    function handleResetPassword(event) {
        event.preventDefault();
        
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;
        
        if (password !== passwordConfirm) {
            alert('Les mots de passe ne correspondent pas !');
            return false;
        }
        
        if (password.length < 8) {
            alert('Le mot de passe doit contenir au moins 8 caractères.');
            return false;
        }
        
        // Simulation de réinitialisation réussie
        alert('✅ Mot de passe réinitialisé avec succès !');
        window.location.href = "{{ route('login') }}";
        
        return false;
    }
</script>
@endsection

@section('footer')
    <a href="{{ route('login') }}">Retour à la connexion</a>
@endsection