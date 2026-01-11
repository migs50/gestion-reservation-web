@extends('layouts.app')

@section('title', 'Demande de compte')

@section('content')
<style>
    .request-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .request-card {
        background: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .request-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .request-header h1 {
        font-size: 32px;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .request-header p {
        color: #7f8c8d;
        font-size: 16px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #2c3e50;
        font-weight: 600;
        font-size: 14px;
    }

    .form-group label .required {
        color: #e74c3c;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #ecf0f1;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-group small {
        display: block;
        margin-top: 5px;
        color: #7f8c8d;
        font-size: 13px;
    }

    .checkbox-group {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin: 20px 0;
    }

    .checkbox-group input[type="checkbox"] {
        width: auto;
        margin-top: 3px;
    }

    .checkbox-group label {
        margin: 0;
        font-weight: normal;
        font-size: 14px;
        color: #555;
    }

    .info-box {
        background: #e7f3ff;
        border-left: 4px solid #2196f3;
        padding: 20px;
        border-radius: 6px;
        margin: 25px 0;
    }

    .info-box h4 {
        color: #1976d2;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .info-box ul {
        margin: 10px 0 0 20px;
        color: #555;
    }

    .info-box ul li {
        margin-bottom: 5px;
    }

    .btn-submit {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .success-message {
        display: none;
        background: #d4edda;
        color: #155724;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #c3e6cb;
        margin-bottom: 20px;
        text-align: center;
    }

    .success-message.show {
        display: block;
    }
</style>

<div class="request-container">
    <div class="request-card">
        <div class="request-header">
            <h1>📝 Demande de création de compte</h1>
            <p>Remplissez ce formulaire pour demander l'accès aux ressources du Data Center</p>
        </div>

        <div class="success-message" id="successMessage">
            <strong>✅ Demande envoyée avec succès !</strong><br>
            Votre demande a été transmise à l'administrateur. Vous recevrez une réponse par email dans les 48 heures.
        </div>

        <div class="info-box">
            <h4>📋 Informations importantes</h4>
            <ul>
                <li>Votre demande sera examinée par un administrateur sous 48 heures</li>
                <li>Vous recevrez un email de confirmation une fois votre compte créé</li>
                <li>Tous les champs marqués d'un astérisque (*) sont obligatoires</li>
                <li>Assurez-vous de fournir une adresse email valide</li>
            </ul>
        </div>

        <form id="requestForm" action="{{ route('demande.compte.store') }}" method="POST">
            @csrf
            
            @if($errors->any())
                <div class="alert alert-danger" style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Informations personnelles -->
            <h3 style="color: #2c3e50; margin-bottom: 20px;">👤 Informations personnelles</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Nom <span class="required">*</span></label>
                    <input type="text" name="nom" value="{{ old('nom') }}" required placeholder="Votre nom">
                </div>

                <div class="form-group">
                    <label>Prénom <span class="required">*</span></label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" required placeholder="Votre prénom">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="votre.email@example.com">
                    <small>Utilisez votre email professionnel ou académique</small>
                </div>

                <div class="form-group">
                    <label>Téléphone <span class="required">*</span></label>
                    <input type="tel" name="telephone" value="{{ old('telephone') }}" required placeholder="+212 6XX-XXXXXX">
                </div>
            </div>

            <!-- Sécurité -->
            <h3 style="color: #2c3e50; margin: 30px 0 20px;">🔒 Sécurité</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Mot de passe <span class="required">*</span></label>
                    <input type="password" name="password" required placeholder="8 caractères minimum">
                </div>

                <div class="form-group">
                    <label>Confirmer le mot de passe <span class="required">*</span></label>
                    <input type="password" name="password_confirmation" required placeholder="Confirmez votre mot de passe">
                </div>
            </div>

            <!-- Informations professionnelles -->
            <h3 style="color: #2c3e50; margin: 30px 0 20px;">🏢 Informations professionnelles</h3>

            <div class="form-row">
                <div class="form-group">
                    <label>Organisation <span class="required">*</span></label>
                    <input type="text" name="organisation" value="{{ old('organisation') }}" required placeholder="Nom de votre entreprise/université">
                </div>

                <div class="form-group">
                    <label>Département/Service <span class="required">*</span></label>
                    <input type="text" name="departement" value="{{ old('departement') }}" required placeholder="Ex: Informatique, R&D">
                </div>
            </div>

            <div class="form-group">
                <label>Fonction/Poste <span class="required">*</span></label>
                <input type="text" name="poste" value="{{ old('poste') }}" required placeholder="Ex: Développeur, Chercheur, Étudiant">
            </div>

            <!-- Détails de la demande -->
            <h3 style="color: #2c3e50; margin: 30px 0 20px;">📌 Détails de la demande</h3>

            <div class="form-group">
                <label>Type de compte souhaité <span class="required">*</span></label>
                <select name="type_demande" required>
                    <option value="">-- Sélectionnez un type --</option>
                    <option value="Interne" {{ old('type_demande') == 'Interne' ? 'selected' : '' }}>Utilisateur Interne</option>
                    <option value="Responsable" {{ old('type_demande') == 'Responsable' ? 'selected' : '' }}>Responsable de Ressource</option>
                </select>
            </div>

            <div class="form-group">
                <label>Justification de la demande <span class="required">*</span></label>
                <textarea name="justification" required placeholder="Expliquez en détail pourquoi vous avez besoin d'accéder aux ressources du Data Center...">{{ old('justification') }}</textarea>
                <small>Minimum 50 caractères</small>
            </div>

            <!-- Acceptation des conditions -->
            <div class="checkbox-group">
                <input type="checkbox" id="acceptRules" name="accept_rules" required>
                <label for="acceptRules">
                    J'ai lu et j'accepte les <a href="{{ route('rules') }}" target="_blank" style="color: #667eea;">règles d'utilisation</a> du Data Center <span class="required">*</span>
                </label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="acceptData" name="accept_data" required>
                <label for="acceptData">
                    J'accepte que mes données soient utilisées dans le cadre du traitement de ma demande <span class="required">*</span>
                </label>
            </div>

            <button type="submit" class="btn-submit">📤 Envoyer la demande</button>
        </form>
    </div>
</div>

<script>
</script>
@endsectionlabel">