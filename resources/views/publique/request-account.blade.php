@extends('layouts.app')

@section('title', 'Demande de compte')

@section('content')


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
            <div class="form-group">
                <label for="secret_question">Question secrète</label>
                <select name="secret_question" id="secret_question" required>
                    <option value="">Choisir une question</option>
                    <option value="school">Nom de votre première école ?</option>
                    <option value="pet">Nom de votre premier animal ?</option>
                    <option value="city">Ville de naissance ?</option>
                </select>
            </div>

            <div class="form-group">
                <label for="secret_answer">Réponse à la question secrète</label>
                <input type="text" id="secret_answer" name="secret_answer" placeholder="Votre réponse" required>
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
                    <option value="Responsable Technique" {{ old('type_demande') == 'Responsable Technique' ? 'selected' : '' }}>Responsable Technique</option>
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
@endsection