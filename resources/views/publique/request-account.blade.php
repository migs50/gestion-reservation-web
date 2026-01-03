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

        <form id="requestForm" onsubmit="handleSubmit(event)">
            @csrf
            <!-- Informations personnelles -->
            <h3 style="color: #2c3e50; margin-bottom: 20px;">👤 Informations personnelles</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Nom <span class="required">*</span></label>
                    <input type="text" name="nom" required placeholder="Votre nom">
                </div>

                <div class="form-group">
                    <label>Prénom <span class="required">*</span></label>
                    <input type="text" name="prenom" required placeholder="Votre prénom">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" required placeholder="votre.email@example.com">
                    <small>Utilisez votre email professionnel ou académique</small>
                </div>

                <div class="form-group">
                    <label>Téléphone <span class="required">*</span></label>
                    <input type="tel" name="telephone" required placeholder="+212 6XX-XXXXXX">
                </div>
            </div>

            <!-- Informations professionnelles -->
            <h3 style="color: #2c3e50; margin: 30px 0 20px;">🏢 Informations professionnelles</h3>

            <div class="form-row">
                <div class="form-group">
                    <label>Organisation <span class="required">*</span></label>
                    <input type="text" name="organisation" required placeholder="Nom de votre entreprise/université">
                </div>

                <div class="form-group">
                    <label>Département/Service <span class="required">*</span></label>
                    <input type="text" name="departement" required placeholder="Ex: Informatique, R&D">
                </div>
            </div>

            <div class="form-group">
                <label>Fonction/Poste <span class="required">*</span></label>
                <input type="text" name="poste" required placeholder="Ex: Développeur, Chercheur, Étudiant">
            </div>

            <!-- Détails de la demande -->
            <h3 style="color: #2c3e50; margin: 30px 0 20px;">📌 Détails de la demande</h3>

            <div class="form-group">
                <label>Type de compte souhaité <span class="required">*</span></label>
                <select name="type_compte" required>
                    <option value="">-- Sélectionnez un type --</option>
                    <option value="utilisateur">Utilisateur Standard</option>
                    <option value="chercheur">Chercheur/Académique</option>
                    <option value="developpeur">Développeur</option>
                    <option value="entreprise">Entreprise/Organisation</option>
                </select>
            </div>

            <div class="form-group">
                <label>Ressources souhaitées <span class="required">*</span></label>
                <select name="ressources" required>
                    <option value="">-- Sélectionnez un type --</option>
                    <option value="serveurs">Serveurs physiques</option>
                    <option value="vm">Machines virtuelles</option>
                    <option value="stockage">Espaces de stockage</option>
                    <option value="reseau">Équipements réseau</option>
                    <option value="tout">Toutes les ressources</option>
                </select>
            </div>

            <div class="form-group">
                <label>Justification de la demande <span class="required">*</span></label>
                <textarea name="justification" required placeholder="Expliquez en détail pourquoi vous avez besoin d'accéder aux ressources du Data Center..."></textarea>
                <small>Minimum 50 caractères</small>
            </div>

            <div class="form-group">
                <label>Durée estimée d'utilisation <span class="required">*</span></label>
                <select name="duree" required>
                    <option value="">-- Sélectionnez une durée --</option>
                    <option value="ponctuel">Ponctuel (moins d'1 mois)</option>
                    <option value="court">Court terme (1-3 mois)</option>
                    <option value="moyen">Moyen terme (3-6 mois)</option>
                    <option value="long">Long terme (plus de 6 mois)</option>
                </select>
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
    function handleSubmit(event) {
        event.preventDefault();
        
        // Validation de la justification
        const justification = document.querySelector('textarea[name="justification"]').value;
        if (justification.length < 50) {
            alert('La justification doit contenir au moins 50 caractères.');
            return false;
        }

        // Simulation d'envoi
        const form = document.getElementById('requestForm');
        const successMessage = document.getElementById('successMessage');
        
        // Afficher le message de succès
        successMessage.classList.add('show');
        
        // Réinitialiser le formulaire
        form.reset();
        
        // Scroll vers le haut
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Masquer le message après 10 secondes
        setTimeout(() => {
            successMessage.classList.remove('show');
        }, 10000);
        
        return false;
    }
</script>
@endsectionlabel">