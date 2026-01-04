@extends('layouts.app')

@section('title', 'Règles d\'utilisation')

@section('content')
<style>
    .rules-container {
        background: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .rules-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .rules-header h1 {
        font-size: 36px;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .rules-header p {
        color: #7f8c8d;
        font-size: 16px;
    }

    .rules-section {
        margin-bottom: 40px;
    }

    .rules-section h2 {
        color: #667eea;
        font-size: 24px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rules-section h3 {
        color: #2c3e50;
        font-size: 20px;
        margin: 25px 0 15px;
    }

    .rules-list {
        list-style: none;
        padding: 0;
    }

    .rules-list li {
        padding: 15px;
        margin-bottom: 10px;
        background: #f8f9fa;
        border-left: 4px solid #667eea;
        border-radius: 6px;
        line-height: 1.6;
    }

    .rules-list li strong {
        color: #2c3e50;
    }

    .warning-box {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 20px;
        border-radius: 6px;
        margin: 20px 0;
    }

    .warning-box h4 {
        color: #856404;
        margin-bottom: 10px;
    }

    .warning-box p {
        color: #856404;
        margin: 0;
    }

    .info-box {
        background: #d1ecf1;
        border-left: 4px solid #17a2b8;
        padding: 20px;
        border-radius: 6px;
        margin: 20px 0;
    }

    .info-box h4 {
        color: #0c5460;
        margin-bottom: 10px;
    }

    .info-box p {
        color: #0c5460;
        margin: 0;
    }

    .acceptance-box {
        background: #f8f9fa;
        border: 2px solid #667eea;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        margin-top: 40px;
    }

    .acceptance-box h3 {
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .acceptance-box p {
        color: #7f8c8d;
        margin-bottom: 20px;
    }
</style>

<div class="rules-container">
    <div class="rules-header">
        <h1>📜 Règles d'utilisation</h1>
        <p>Conditions générales d'utilisation des ressources du Data Center</p>
    </div>

    <!-- Section 1 -->
    <div class="rules-section">
        <h2>🎯 1. Objectif et portée</h2>
        <p>
            Les présentes règles définissent les conditions d'accès et d'utilisation des ressources informatiques 
            mises à disposition par le Data Center. Elles s'appliquent à tous les utilisateurs, qu'ils soient 
            internes ou externes à l'organisation.
        </p>
    </div>

    <!-- Section 2 -->
    <div class="rules-section">
        <h2>👤 2. Droits et responsabilités des utilisateurs</h2>
        
        <h3>2.1 Droits des utilisateurs</h3>
        <ul class="rules-list">
            <li><strong>Accès aux ressources :</strong> Tout utilisateur validé peut réserver et utiliser les ressources disponibles selon les modalités définies.</li>
            <li><strong>Support technique :</strong> Un support est disponible 24/7 pour toute assistance technique.</li>
            <li><strong>Notifications :</strong> Vous serez informé de toute maintenance planifiée ou incident affectant vos ressources.</li>
            <li><strong>Confidentialité :</strong> Vos données sont protégées et ne seront jamais partagées sans votre consentement.</li>
        </ul>

        <h3>2.2 Responsabilités des utilisateurs</h3>
        <ul class="rules-list">
            <li><strong>Sécurité des accès :</strong> Vous êtes responsable de la confidentialité de vos identifiants de connexion.</li>
            <li><strong>Utilisation appropriée :</strong> Les ressources doivent être utilisées uniquement à des fins professionnelles ou académiques légitimes.</li>
            <li><strong>Respect des quotas :</strong> Vous devez respecter les limitations de ressources allouées (CPU, RAM, stockage, bande passante).</li>
            <li><strong>Signalement d'incidents :</strong> Tout problème technique ou comportement suspect doit être signalé immédiatement.</li>
        </ul>
    </div>

    <!-- Section 3 -->
    <div class="rules-section">
        <h2>📅 3. Réservation des ressources</h2>
        
        <h3>3.1 Procédure de réservation</h3>
        <ul class="rules-list">
            <li><strong>Durée maximale :</strong> Les réservations ne peuvent excéder 30 jours consécutifs.</li>
            <li><strong>Délai de préavis :</strong> Une réservation doit être effectuée au moins 24 heures à l'avance.</li>
            <li><strong>Approbation :</strong> Toute réservation est soumise à l'approbation du responsable des ressources.</li>
            <li><strong>Modification :</strong> Les modifications de réservation doivent être effectuées au moins 12 heures avant le début.</li>
        </ul>

        <h3>3.2 Annulation et libération</h3>
        <ul class="rules-list">
            <li><strong>Annulation :</strong> Les réservations peuvent être annulées jusqu'à 6 heures avant le début.</li>
            <li><strong>Libération automatique :</strong> Les ressources non utilisées pendant 48 heures seront automatiquement libérées.</li>
            <li><strong>Pénalités :</strong> Les annulations répétées ou tardives peuvent entraîner une suspension temporaire du droit de réservation.</li>
        </ul>
    </div>

    <div class="warning-box">
        <h4>⚠️ Important</h4>
        <p>
            Les réservations non justifiées ou l'utilisation abusive des ressources peuvent entraîner la suspension 
            ou la révocation de votre compte. Assurez-vous de libérer les ressources dès que vous n'en avez plus besoin.
        </p>
    </div>

    <!-- Section 4 -->
    <div class="rules-section">
        <h2>🔒 4. Sécurité et confidentialité</h2>
        
        <ul class="rules-list">
            <li><strong>Mots de passe :</strong> Les mots de passe doivent contenir au moins 12 caractères avec majuscules, minuscules, chiffres et caractères spéciaux.</li>
            <li><strong>Authentification :</strong> L'authentification à deux facteurs (2FA) est obligatoire pour tous les comptes.</li>
            <li><strong>Accès réseau :</strong> L'accès aux ressources se fait exclusivement via VPN sécurisé ou depuis les réseaux autorisés.</li>
            <li><strong>Sauvegardes :</strong> Vous êtes responsable de la sauvegarde de vos données. Des sauvegardes automatiques sont effectuées quotidiennement mais ne remplacent pas vos propres sauvegardes.</li>
            <li><strong>Chiffrement :</strong> Les données sensibles doivent être chiffrées lors du stockage et de la transmission.</li>
        </ul>
    </div>

    <!-- Section 5 -->
    <div class="rules-section">
        <h2>🚫 5. Utilisations interdites</h2>
        
        <ul class="rules-list">
            <li><strong>Activités illégales :</strong> Toute utilisation à des fins illégales est strictement interdite.</li>
            <li><strong>Attaques :</strong> Les tests de pénétration, scans de vulnérabilités ou attaques contre d'autres systèmes sont interdits sans autorisation préalable écrite.</li>
            <li><strong>Mining de cryptomonnaies :</strong> L'utilisation des ressources pour le minage de cryptomonnaies est interdite.</li>
            <li><strong>Serveurs publics :</strong> L'hébergement de services publics (web, FTP, etc.) non autorisés est interdit.</li>
            <li><strong>Spam et malware :</strong> La distribution de spam ou de logiciels malveillants est strictement interdite.</li>
            <li><strong>Revente :</strong> La revente ou sous-location des ressources à des tiers est interdite.</li>
        </ul>
    </div>

    <div class="warning-box">
        <h4>⚠️ Sanctions</h4>
        <p>
            Toute violation des règles d'utilisation peut entraîner : suspension immédiate du compte, 
            révocation définitive de l'accès, poursuites judiciaires en cas d'activités illégales, 
            facturation des dommages causés.
        </p>
    </div>

    <!-- Section 6 -->
    <div class="rules-section">
        <h2>🔧 6. Maintenance et disponibilité</h2>
        
        <ul class="rules-list">
            <li><strong>SLA :</strong> Le Data Center garantit une disponibilité de 99.5% hors maintenance planifiée.</li>
            <li><strong>Maintenance planifiée :</strong> Les maintenances sont annoncées au moins 7 jours à l'avance et se déroulent généralement entre 2h et 6h du matin.</li>
            <li><strong>Maintenance d'urgence :</strong> En cas d'urgence, une maintenance peut être effectuée avec un préavis de 2 heures.</li>
            <li><strong>Compensation :</strong> Aucune compensation n'est due pour les interruptions de service lors de maintenances planifiées.</li>
        </ul>
    </div>

    <!-- Section 7 -->
    <div class="rules-section">
        <h2>📞 7. Support et assistance</h2>
        
        <div class="info-box">
            <h4>ℹ️ Contacts support</h4>
            <p>
                <strong>Email :</strong> support@datacenter.local<br>
                <strong>Téléphone :</strong> +212 5XX-XXXXXX<br>
                <strong>Disponibilité :</strong> 24/7<br>
                <strong>Temps de réponse :</strong> Moins de 2 heures pour les incidents critiques
            </p>
        </div>
    </div>

    <!-- Section 8 -->
    <div class="rules-section">
        <h2>📝 8. Modifications des règles</h2>
        
        <p>
            Le Data Center se réserve le droit de modifier ces règles à tout moment. Les utilisateurs seront 
            informés par email de toute modification substantielle. La poursuite de l'utilisation des ressources 
            après notification vaut acceptation des nouvelles règles.
        </p>
    </div>

    <!-- Acceptance Box -->
    <div class="acceptance-box">
        <h3>✅ Acceptation des règles</h3>
        <p>
            En créant un compte et en utilisant les ressources du Data Center, vous acceptez de respecter 
            l'intégralité de ces règles d'utilisation.
        </p>
       <a href="{{ route('demande.compte') }}" class="btn-reserve">Demander un compte</a>

    </div>
</div>
@endsection