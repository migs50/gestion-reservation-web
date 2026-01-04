@extends('layouts.auth')

@section('title', 'Inscription')

@section('subtitle', 'Créez votre compte utilisateur')

@section('content')
<style>
    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #333;
        font-weight: 500;
        font-size: 14px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus {
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

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .checkbox-group {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin: 15px 0;
    }

    .checkbox-group input[type="checkbox"] {
        width: auto;
        margin-top: 3px;
    }

    .checkbox-group label {
        margin: 0;
        font-weight: normal;
        font-size: 13px;
        color: #555;
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

    @media (max-width: 480px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@if ($errors->any())
    <div style="color:red; margin-bottom:10px;">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif


<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group">
        <label for="nom_complet">Nom complet</label>
        <input type="text" id="nom_complet" name="nom_complet" required>
    </div>

    <div class="form-group">
        <label for="email">Adresse email</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="telephone">Téléphone</label>
        <input type="tel" id="telephone" name="telephone" required>
    </div>

    <div class="form-group">
        <label for="type_demande">Type de compte</label>
        <select id="type_demande" name="type_demande" required>
            <option value="Interne">Interne</option>
            <option value="Responsable">Responsable</option>
        </select>
    </div>

    <div class="form-group">
        <label for="justification">Justification</label>
        <textarea id="justification" name="justification" required></textarea>
    </div>

    <button type="submit" class="btn">Envoyer la demande</button>
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

                                                            //HIS CODE IS COMMENT IT DOES NOT WORK IN LARAVEL ITS A BLADE COMMENT, COMMENTED INSTEAD OF DELETED (ADAM)
                                                                {{-- function handleRegister(event) {
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
                                                                    
                                                                    // Simulation d'inscription réussie
                                                                    alert('✅ Inscription réussie ! Votre compte a été créé.');
                                                                    window.location.href = "{{ route('login') }}";
                                                                    
                                                                    return false;
                                                                } --}}
</script>
@endsection

@section('footer')
    Vous avez déjà un compte ? 
    <a href="{{ route('login') }}">Se connecter</a>
@endsection
