@extends('layouts.guest')

@section('title', "Règles d'utilisation - Data Center")

@section('content')

<style>
    .rules-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .rules-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 3px solid #2563eb;
        }

        .rules-header h1 {
            font-size: 2.5rem;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .rules-header p {
            font-size: 1.1rem;
            color: #64748b;
        }

        .table-of-contents {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            border-left: 4px solid #2563eb;
        }

        .table-of-contents h3 {
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .table-of-contents ul {
            list-style: none;
        }

        .table-of-contents li {
            margin-bottom: 0.5rem;
        }

        .table-of-contents a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .table-of-contents a:hover {
            color: #1e40af;
            padding-left: 0.5rem;
        }

        .rule-section {
            margin-bottom: 3rem;
            scroll-margin-top: 100px;
        }

        .rule-section h2 {
            font-size: 1.75rem;
            color: #0f172a;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .rule-section h3 {
            font-size: 1.35rem;
            color: #334155;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .rule-section p {
            line-height: 1.8;
            color: #475569;
            margin-bottom: 1rem;
        }

        .rule-section ul {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .rule-section li {
            line-height: 1.8;
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .highlight-box {
            background: linear-gradient(135deg, #dbeafe, #eff6ff);
            border-left: 4px solid #2563eb;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        .highlight-box h4 {
            color: #1e40af;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }

        .warning-box {
            background: linear-gradient(135deg, #fef3c7, #fef9c3);
            border-left: 4px solid #f59e0b;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        .warning-box h4 {
            color: #92400e;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-types-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 1.5rem 0;
        }

        .user-type-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .user-type-card:hover {
            border-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .user-type-card h4 {
            color: #0f172a;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-type-icon {
            font-size: 1.5rem;
        }

        .contact-cta {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            margin-top: 3rem;
        }

        .contact-cta h3 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .contact-cta p {
            margin-bottom: 1.5rem;
            opacity: 0.95;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .rules-container {
                padding: 1.5rem;
            }

            .rules-header h1 {
                font-size: 1.75rem;
            }

            .user-types-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
   
<div class="container mt-4">
    <div class="rules-container">

        <!-- HEADER -->
        <div class="rules-header">
            <h1>Règles d'Utilisation du Data Center</h1>
            <p>Conditions générales et bonnes pratiques pour l'utilisation des ressources</p>
        </div>

        <!-- INTRODUCTION -->
        <section class="rule-section">
            <h2><span class="section-icon">📘</span>Introduction</h2>

            <p>
                La plateforme de gestion du Data Center est mise à disposition des membres de notre organisation
                pour faciliter l'accès aux ressources informatiques (serveurs physiques, machines virtuelles,
                équipements de stockage et réseau).
            </p>

            <p>
                L'utilisation de la plateforme implique l'acceptation sans réserve de ces conditions.
                Tout utilisateur s'engage à respecter ces règles ainsi que les politiques de sécurité informatique.
            </p>

            <div class="highlight-box">
                <h4>🎯 Objectifs de la plateforme</h4>
                <ul>
                    <li>Optimiser l'utilisation des ressources du Data Center</li>
                    <li>Garantir un accès équitable à tous les utilisateurs</li>
                    <li>Assurer la traçabilité et la transparence des allocations</li>
                    <li>Faciliter la maintenance et la planification</li>
                </ul>
            </div>
        </section>

        <!-- PROCESSUS DE RÉSERVATION -->
        <section class="rule-section">
            <h2><span class="section-icon">📅</span>Processus de réservation</h2>

            <h3>Demande de réservation</h3>
            <ol>
                <li>Sélection des ressources dans le catalogue</li>
                <li>Définition de la période de réservation</li>
                <li>Justification du besoin</li>
                <li>Validation et soumission</li>
            </ol>

            <div class="highlight-box">
                <h4>⏱️ Délais de traitement</h4>
                <p>Les demandes standard sont traitées sous 48 heures ouvrables.</p>
            </div>

            <h3>Critères d'approbation</h3>
            <ul>
                <li>Disponibilité des ressources</li>
                <li>Pertinence de la justification</li>
                <li>Historique d'utilisation</li>
                <li>Priorités institutionnelles</li>
                <li>Respect des quotas</li>
            </ul>

            <h3>Modification et annulation</h3>
            <ul>
                <li>Modification possible jusqu'à 24h avant</li>
                <li>Annulation minimum 12h avant</li>
                <li>Abus = pénalité sur futures demandes</li>
            </ul>
        </section>

        <!-- RÈGLES D’UTILISATION -->
        <section class="rule-section">
            <h2><span class="section-icon">📜</span>Règles d'utilisation</h2>

            <h3>Durée maximale</h3>
            <ul>
                <li>Serveurs physiques : 3 mois</li>
                <li>Machines virtuelles : 6 mois</li>
                <li>Stockage : 12 mois</li>
                <li>Équipements réseau : 1 mois</li>
            </ul>

            <h3>Limites par utilisateur</h3>
            <ul>
                <li>2 serveurs physiques max</li>
                <li>5 machines virtuelles max</li>
                <li>5 TB stockage max</li>
                <li>3 demandes en attente max</li>
            </ul>

            <div class="warning-box">
                <h4>⚠️ Utilisations interdites</h4>
                <ul>
                    <li>Activités illégales</li>
                    <li>Minage de cryptomonnaies</li>
                    <li>Services commerciaux non autorisés</li>
                    <li>Partage d'accès</li>
                    <li>Tests offensifs sans autorisation</li>
                </ul>
            </div>

            <h3>Bonnes pratiques</h3>
            <ul>
                <li>Libérer les ressources inutilisées</li>
                <li>Optimiser l'utilisation</li>
                <li>Sauvegarder les données</li>
                <li>Mettre à jour les systèmes</li>
                <li>Documenter les configurations</li>
            </ul>
        </section>

        <!-- RESPONSABILITÉS -->
        <section class="rule-section">
            <h2><span class="section-icon">✅</span>Responsabilités</h2>

            <h3>Utilisateur</h3>
            <ul>
                <li>Confidentialité des identifiants</li>
                <li>Respect des règles</li>
                <li>Sauvegarde des données</li>
                <li>Signalement des incidents</li>
            </ul>

            <h3>Data Center</h3>
            <ul>
                <li>Disponibilité SLA 99.5%</li>
                <li>Sécurité des infrastructures</li>
                <li>Maintenance planifiée</li>
                <li>Support technique</li>
            </ul>

            <div class="highlight-box">
                <h4>📞 Support technique</h4>
                <p>
                    Email : support@datacenter.ma <br>
                    Téléphone : +212 5XX-XXXXXX <br>
                    Horaires : Lundi–Vendredi, 9h–18h
                </p>
            </div>
        </section>

        <!-- SÉCURITÉ -->
        <section class="rule-section">
            <h2><span class="section-icon">🔒</span>Sécurité et conformité</h2>

            <ul>
                <li>Mots de passe forts obligatoires</li>
                <li>MFA recommandé</li>
                <li>Chiffrement des données</li>
                <li>Mises à jour régulières</li>
            </ul>
        </section>

        <!-- SANCTIONS -->
        <section class="rule-section">
            <h2><span class="section-icon">⚖️</span>Sanctions</h2>

            <ol>
                <li>Avertissement</li>
                <li>Suspension temporaire</li>
                <li>Révocation des privilèges</li>
                <li>Suspension définitive</li>
            </ol>

            <div class="warning-box">
                <h4>⚠️ Infractions graves</h4>
                <p>Suspension immédiate et poursuites possibles.</p>
            </div>
        </section>

        <!-- CTA -->
        <div class="contact-cta">
            <h3>Prêt à utiliser nos ressources ?</h3>
            <p>Déposez votre demande de compte dès maintenant</p>

            <a href="{{ route('demande.compte') }}" class="btn btn-light">Demander un compte</a>
            <a href="{{ route('catalogue') }}" class="btn btn-outline-light">Consulter les ressources</a>
        </div>

    </div>
</div>
 

@endsection
