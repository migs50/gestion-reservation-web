@extends('layouts.guest')

@push('styles')
<style>
.login-page {
min-height: calc(100vh - 200px);
display: flex;
align-items: center;
padding: 2rem 0;
background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}
    .login-container {
        max-width: 450px;
        margin: 0 auto;
        width: 100%;
        background:#ffffff;
        border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);
        max-width:480px;width:100%;padding:3rem;
        animation:slideUp .5s
         ease
    }

    .login-card {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        padding: 3rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        animation: slideUp 0.5s ease;
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
        font-weight: bold;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    .login-header h1 {
        font-size: 1.75rem;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }

    .login-header p {
        color: #64748b;
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .password-container {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 0.5rem;
        font-size: 1.25rem;
        transition: color 0.3s ease;
    }

    .password-toggle:hover {
        color: #2563eb;
    }

    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .remember-me input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .forgot-link {
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .forgot-link:hover {
        color: #1e40af;
        text-decoration: underline;
    }

    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 2rem 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e2e8f0;
    }

    .divider span {
        padding: 0 1rem;
    }

    .no-account {
        text-align: center;
        color: #64748b;
        font-size: 0.95rem;
    }

    .no-account a {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .no-account a:hover {
        color: #1e40af;
        text-decoration: underline;
    }

    .features-list {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
    }

    .features-list h3 {
        font-size: 1rem;
        color: #0f172a;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .features-list ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .features-list li {
        color: #475569;
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .features-list li::before {
        content: '✓';
        color: #10b981;
        font-weight: bold;
        flex-shrink: 0;
    }

    .alert-demo {
        background: linear-gradient(135deg, #fef3c7, #fef9c3);
        border: 2px solid #f59e0b;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        gap: 0.75rem;
    }

    .alert-demo-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .alert-demo-content {
        flex: 1;
    }

    .alert-demo-title {
        font-weight: 600;
        color: #92400e;
        margin-bottom: 0.25rem;
    }

    .alert-demo-text {
        font-size: 0.9rem;
        color: #92400e;
        margin: 0;
    }

    @media (max-width: 480px) {
        .login-card {
            padding: 2rem 1.5rem;
        }

        .remember-forgot {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')
<!-- Main Content -->
<div class="login-page">
    <div class="container">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-logo">DC</div>
                    <h1>Connexion</h1>
                    <p>Accédez à votre espace de gestion des ressources</p>
                </div>
                   </div>
                  @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                          </ul>
            </div>
        @endif

                <!-- Demo Alert -->
                <div class="alert-demo">
                    <div class="alert-demo-icon">ℹ️</div>
                    <div class="alert-demo-content">
                        <div class="alert-demo-title">Version de démonstration</div>
                        <p class="alert-demo-text">Cette page est une interface de démonstration. Dans la version Laravel, l'authentification sera gérée par le système d'authentification intégré.</p>
                    </div>
                </div>

                <!-- Login Form -->
                <form  method="POST" action="{{ route('login') }}" id="loginForm">
                    <div class="form-group">
                        <label class="form-label required" for="email">Email</label>
                        <input
                            type="email"
                            id="email"
                            class="form-input"
                            name="email"
                             value="{{ old('email') }}"
                            placeholder="votreemail@gmail.ma"
                            required
                            autocomplete="email">
                        <span class="form-error">Veuillez saisir une adresse email valide</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="password">Mot de passe</label>
                        <div class="password-container">
                            <input
                                type="password"
                                id="password"
                                class="form-input"
                                name="password"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password">
                            <button type="button" class="password-toggle" id="togglePassword">
                                👁️
                            </button>
                        </div>
                        <span class="form-error">Veuillez saisir votre mot de passe</span>
                    </div>

                    <div class="remember-forgot">
                        <label class="remember-me" name="remember"  >
                            <input type="checkbox" id="remember">
                            <span>Se souvenir de moi</span>
                        </label>
                        <a  href="{{ route('password.request') }}" class="forgot-link" id="forgotLink">Mot de passe oublié ?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-large">
                        Se connecter
                    </button>
                </form>

                <div class="divider">
                    <span>ou</span>
                </div>

                <div class="no-account">
                    Vous n'avez pas encore de compte ?
                    <a href="{{ route('register') }}">Créer un compte</a>
                </div>

                <!-- Features List -->
                <div class="features-list">
                    <h3>🚀 Avec votre compte, vous pouvez :</h3>
                    <ul>
                        <li>Réserver des ressources en temps réel</li>
                        <li>Suivre l'état de vos demandes</li>
                        <li>Consulter l'historique de vos réservations</li>
                        <li>Recevoir des notifications automatiques</li>
                        <li>Signaler des incidents techniques</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Password toggle
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    if (passwordInput && togglePassword) {
        togglePassword.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                togglePassword.textContent = '👁️';
            }
        });
    }

    // Login form - soumission directe
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            let isValid = true;

            if (!email.value.trim() || !email.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                email.classList.add('error');
                isValid = false;
                e.preventDefault();
            } else {
                email.classList.remove('error');
            }

            if (!password.value.trim()) {
                password.classList.add('error');
                isValid = false;
                e.preventDefault();
            } else {
                password.classList.remove('error');
            }
        });
    }

    // Remove error on input
    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('error');
        });
    });
});
</script>
@endpush