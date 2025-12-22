<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Règles d'Utilisation - Data Center</title>
    <link rel="stylesheet" href="styles.css">
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
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.html" class="logo">
                <div class="logo-icon">DC</div>
                <span>Data Center</span>
            </a>
            <button class="menu-toggle" id="menuToggle">☰</button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.html" class="nav-link">Accueil</a></li>
                <li><a href="catalogue.html" class="nav-link">Ressources</a></li>
                <li><a href="regles.html" class="nav-link">Règles d'utilisation</a></li>
                <li><a href="demande-compte.html" class="nav-btn">Demander un compte</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="rules-container">
            <div class="rules-header">
                <h1>Règles d'Utilisation du Data Center</h1>
                <p>Conditions générales et bonnes pratiques pour l'utilisation des ressources</p>
            </div>

            <!-- Table of Contents -->
            <div class="table-of-contents">
                <h3>📋 Table des matières</h3>
                <ul>
                    <li><a href="#introduction">1. Introduction</a></li>
                    <li><a href="#reservation">2. Processus de réservation</a></li>
                    <li><a href="#usage-rules">3. Règles d'utilisation</a></li>
                    <li><a href="#responsibilities">4. Responsabilités</a></li>
                    <li><a href="#security">5. Sécurité et conformité</a></li>
                    <li><a href="#sanctions">6. Sanctions</a></li>
                </ul>
            </div>

            <!-- Introduction -->
            <section id="introduction" class="rule-section">
                <h2>
                    <span class="section-icon">📘</span>
                    Introduction
                </h2>
                <p>
                    La plateforme de gestion du Data Center est mise à disposition des membres de notre organisation pour faciliter l'accès aux ressources informatiques (serveurs physiques, machines virtuelles, équipements de stockage et réseau). Ces règles visent à garantir une utilisation équitable, sécurisée et efficace de ces ressources.
                </p>
                <p>
                    L'utilisation de la plateforme implique l'acceptation sans réserve de ces conditions. Tout utilisateur s'engage à respecter ces règles ainsi que les politiques de sécurité informatique de l'organisation.
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

            <!-- Reservation Process -->
            <section id="reservation" class="rule-section">
                <h2>
                    <span class="section-icon">📅</span>
                    Processus de réservation
                </h2>

                <h3>Demande de réservation</h3>
                <p>
                    Tout utilisateur interne peut soumettre une demande de réservation en respectant les étapes suivantes :
                </p>
                <ol>
                    <li>Sélection de la ou des ressources souhaitées dans le catalogue</li>
                    <li>Définition de la période de réservation (date de début et de fin)</li>
                    <li>Justification détaillée du besoin (projet, recherche, formation)</li>
                    <li>Validation et soumission de la demande</li>
                </ol>

                <div class="highlight-box">
                    <h4>⏱️ Délais de traitement</h4>
                    <p style="color: #1e3a8a; margin-bottom: 0;">
                        Les demandes standard sont traitées sous 48 heures ouvrables. Pour les demandes urgentes, merci de contacter directement le responsable technique concerné.
                    </p>
                </div>

                <h3>Critères d'approbation</h3>
                <p>Les responsables techniques évaluent les demandes selon :</p>
                <ul>
                    <li>La disponibilité de la ressource pendant la période demandée</li>
                    <li>La pertinence de la justification fournie</li>
                    <li>L'historique d'utilisation du demandeur</li>
                    <li>Les priorités institutionnelles</li>
                    <li>Le respect des quotas et limites</li>
                </ul>

                <h3>Modification et annulation</h3>
                <p>
                    Les réservations approuvées peuvent être modifiées ou annulées sous les conditions suivantes :
                </p>
                <ul>
                    <li>Modification : possible jusqu'à 24 heures avant le début, sous réserve de disponibilité</li>
                    <li>Annulation : à effectuer au minimum 12 heures avant le début de la réservation</li>
                    <li>Les annulations répétées sans justification peuvent impacter les futures demandes</li>
                </ul>
            </section>

            <!-- Usage Rules -->
            <section id="usage-rules" class="rule-section">
                <h2>
                    <span class="section-icon">📜</span>
                    Règles d'utilisation
                </h2>

                <h3>Durée maximale des réservations</h3>
                <ul>
                    <li><strong>Serveurs physiques :</strong> Maximum 3 mois renouvelable</li>
                    <li><strong>Machines virtuelles :</strong> Maximum 6 mois renouvelable</li>
                    <li><strong>Stockage :</strong> Maximum 12 mois avec révision trimestrielle</li>
                    <li><strong>Équipements réseau :</strong> Selon les besoins, généralement 1 mois</li>
                </ul>

                <h3>Limites par utilisateur</h3>
                <p>Sauf autorisation spéciale, les limites suivantes s'appliquent :</p>
                <ul>
                    <li>Maximum 2 serveurs physiques simultanément</li>
                    <li>Maximum 5 machines virtuelles simultanément</li>
                    <li>Maximum 5 TB d'espace de stockage</li>
                    <li>Maximum 3 demandes en attente</li>
                </ul>

                <div class="warning-box">
                    <h4><span>⚠️</span>Utilisations interdites</h4>
                    <ul style="color: #92400e; margin-bottom: 0;">
                        <li>Activités illégales ou contraires à l'éthique</li>
                        <li>Minage de cryptomonnaies</li>
                        <li>Hébergement de services commerciaux non autorisés</li>
                        <li>Partage non autorisé des accès avec des tiers</li>
                        <li>Tests de sécurité offensifs sans autorisation préalable</li>
                    </ul>
                </div>

                <h3>Bonnes pratiques</h3>
                <ul>
                    <li>Libérer les ressources dès qu'elles ne sont plus nécessaires</li>
                    <li>Optimiser l'utilisation des ressources allouées</li>
                    <li>Sauvegarder régulièrement vos données importantes</li>
                    <li>Appliquer les mises à jour de sécurité</li>
                    <li>Documenter vos configurations</li>
                    <li>Signaler rapidement tout incident ou dysfonctionnement</li>
                </ul>
            </section>

            <!-- Responsibilities -->
            <section id="responsibilities" class="rule-section">
                <h2>
                    <span class="section-icon">✅</span>
                    Responsabilités
                </h2>

                <h3>Responsabilités de l'utilisateur</h3>
                <ul>
                    <li>Maintenir la confidentialité de ses identifiants de connexion</li>
                    <li>Utiliser les ressources conformément aux règles établies</li>
                    <li>Sauvegarder ses propres données</li>
                    <li>Signaler tout incident de sécurité dans les plus brefs délais</li>
                    <li>Respecter les licences logicielles</li>
                    <li>Libérer les ressources à la fin de la période de réservation</li>
                </ul>

                <h3>Responsabilités du Data Center</h3>
                <ul>
                    <li>Assurer la disponibilité des ressources (SLA 99.5%)</li>
                    <li>Maintenir la sécurité physique et logique des infrastructures</li>
                    <li>Effectuer les maintenances préventives avec préavis de 7 jours</li>
                    <li>Fournir un support technique pendant les heures ouvrables</li>
                    <li>Assurer la sauvegarde des systèmes critiques</li>
                </ul>

                <div class="highlight-box">
                    <h4>📞 Support technique</h4>
                    <p style="color: #1e3a8a; margin-bottom: 0.5rem;">
                        <strong>Email :</strong> support@datacenter.ma<br>
                        <strong>Téléphone :</strong> +212 5XX-XXXXXX<br>
                        <strong>Horaires :</strong> Lundi-Vendredi, 9h00-18h00
                    </p>
                </div>
            </section>

            <!-- Security -->
            <section id="security" class="rule-section">
                <h2>
                    <span class="section-icon">🔒</span>
                    Sécurité et conformité
                </h2>

                <h3>Politiques de sécurité</h3>
                <ul>
                    <li>Utilisation obligatoire de mots de passe robustes (min. 12 caractères)</li>
                    <li>Activation de l'authentification multi-facteurs recommandée</li>
                    <li>Chiffrement des données sensibles obligatoire</li>
                    <li>Mise à jour régulière des systèmes et applications</li>
                    <li>Respect des politiques de pare-feu et de segmentation réseau</li>
                </ul>

                <h3>Protection des données</h3>
                <p>
                    Conformément aux réglementations en vigueur (RGPD, lois locales), l'utilisateur doit :
                </p>
                <ul>
                    <li>Traiter les données personnelles de manière légale et transparente</li>
                    <li>Implémenter des mesures de protection appropriées</li>
                    <li>Notifier toute violation de données dans les 72 heures</li>
                    <li>Obtenir les consentements nécessaires le cas échéant</li>
                </ul>

                <h3>Audits et contrôles</h3>
                <p>
                    Le Data Center se réserve le droit d'effectuer des audits de sécurité et de conformité. Les logs d'accès et d'utilisation sont conservés pendant 12 mois à des fins de traçabilité.
                </p>
            </section>

            <!-- Sanctions -->
            <section id="sanctions" class="rule-section">
                <h2>
                    <span class="section-icon">⚖️</span>
                    Sanctions
                </h2>

                <p>
                    Le non-respect des présentes règles peut entraîner les sanctions suivantes, selon la gravité de l'infraction :
                </p>

                <h3>Sanctions graduelles</h3>
                <ol>
                    <li><strong>Avertissement :</strong> Pour infractions mineures ou première violation</li>
                    <li><strong>Suspension temporaire :</strong> Blocage de l'accès pour une durée déterminée</li>
                    <li><strong>Révocation des privilèges :</strong> Retrait du droit de réservation</li>
                    <li><strong>Suspension définitive :</strong> Fermeture du compte pour infractions graves</li>
                </ol>

                <div class="warning-box">
                    <h4><span>⚠️</span>Infractions graves</h4>
                    <p style="color: #92400e; margin-bottom: 0;">
                        Les violations graves (activités illégales, compromission de la sécurité, usage malveillant) peuvent entraîner une suspension immédiate et des poursuites selon les cas.
                    </p>
                </div>

                <h3>Procédure de recours</h3>
                <p>
                    Tout utilisateur sanctionné peut faire appel de la décision auprès de l'administrateur du Data Center dans un délai de 15 jours. L'appel doit être motivé par écrit et sera examiné par une commission dédiée.
                </p>
            </section>

            <!-- CTA Section -->
            <div class="contact-cta">
                <h3>Prêt à utiliser nos ressources ?</h3>
                <p>Déposez votre demande de compte dès maintenant et commencez à réserver les ressources dont vous avez besoin</p>
                <div class="cta-buttons">
                    <a href="demande-compte.html" class="btn btn-primary btn-large">Demander un compte</a>
                    <a href="catalogue.html" class="btn btn-outline btn-large" style="background: white; color: #2563eb;">Consulter les ressources</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-bottom">
                <p>&copy; 2025 Data Center. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Menu mobile toggle
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');
        menuToggle.addEventListener('click', () => navMenu.classList.toggle('active'));

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>