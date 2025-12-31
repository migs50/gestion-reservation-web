@extends('layouts.guest')

@section('title', 'Mot de passe oublié - Data Center')

@push('styles')
<style>
    .forgot-password-page{flex:1;display:flex;align-items:center;justify-content:center;padding:3rem 1rem}
    .forgot-password-container{background:#ffffff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);max-width:480px;width:100%;padding:3rem;animation:slideUp .5s ease}
    @keyframes slideUp{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
    .forgot-password-header{text-align:center;margin-bottom:2rem}
    .forgot-password-icon{width:80px;height:80px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;font-size:2.5rem}
    .forgot-password-header h1{font-size:1.875rem;color:#0f172a;margin:0 0 .5rem 0}
    .forgot-password-header p{color:#64748b;margin:0;font-size:1rem;line-height:1.6}
    .form-group{margin-bottom:1.5rem}
    .form-label{display:block;font-weight:600;color:#0f172a;margin-bottom:.5rem;font-size:.95rem}
    .form-input{width:100%;padding:.875rem 1rem;border:2px solid #e2e8f0;border-radius:8px;font-size:1rem;transition:all .2s;box-sizing:border-box}
    .form-input:focus{outline:0;border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
    .form-input.error{border-color:#ef4444}
    .form-error{display:none;color:#ef4444;font-size:.875rem;margin-top:.5rem}
    .form-error.show{display:block}
    .btn{width:100%;padding:.875rem;border-radius:8px;font-weight:600;font-size:1rem;cursor:pointer;transition:all .2s;border:none}
    .btn-primary{background:#3b82f6;color:#fff}
    .btn-primary:hover:not(:disabled){background:#2563eb;transform:translateY(-1px);box-shadow:0 4px 12px rgba(59,130,246,.4)}
    .btn-primary:disabled{opacity:.6;cursor:not-allowed}
    .spinner{display:inline-block;width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .6s linear infinite;margin-right:.5rem}
    @keyframes spin{to{transform:rotate(360deg)}}
    .info-box{background:#eff6ff;border-left:4px solid #3b82f6;padding:1rem;border-radius:8px;margin-bottom:1.5rem}
    .info-box p{margin:0;color:#1e3a8a;font-size:.9rem;line-height:1.5}
    .alert{padding:1rem;border-radius:8px;margin-bottom:1.5rem}
    .alert-error{background:#fee;border:1px solid #fcc;color:#c33}
    .alert ul{margin:.5rem 0 0 0;padding-left:1.5rem}
    .form-actions{display:flex;flex-direction:column;gap:1rem}
    .link{text-align:center;color:#3b82f6;text-decoration:none;font-weight:500;transition:color .2s}
    .link:hover{color:#2563eb}

    @media (max-width:768px){
        .forgot-password-container{padding:2rem}
        .forgot-password-header h1{font-size:1.5rem}
    }
</style>
@endpush

@section('content')
<div class="forgot-password-page">
    <div class="forgot-password-container">
        <div class="forgot-password-header">
            <div class="forgot-password-icon">🔒</div>
            <h1>Mot de passe oublié</h1>
            <p>Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>
        </div>

        <div class="alert alert-error" id="successMessage" style="display:none;">
            <strong>✓ Email envoyé avec succès !</strong><br>
            Vérifiez votre boîte de réception. Le lien expirera dans 60 minutes.
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

        <form id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="info-box">
                <p>💡 Si vous ne recevez pas d'email, vérifiez vos spams ou contactez l'administrateur.</p>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Adresse email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                >
                
                <span class="form-error" id="emailError">Veuillez saisir une adresse email valide</span>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    Envoyer le lien
                </button>
                <a href="{{ route('login') }}" class="link">Retour à la connexion</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const emailInput=document.getElementById('email');
    const emailError=document.getElementById('emailError');

    emailInput.addEventListener('input',function(){
        this.classList.remove('error');
        emailError.classList.remove('show');
    });

    document.getElementById('forgotPasswordForm').addEventListener('submit',function(e){
        const email=emailInput.value.trim();
        const emailPattern=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        emailInput.classList.remove('error');
        emailError.classList.remove('show');

        if(!email||!emailPattern.test(email)){
            e.preventDefault();
            emailInput.classList.add('error');
            emailError.classList.add('show');
            return false;
        }
    });
</script>
@endpush