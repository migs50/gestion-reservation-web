@extends('layouts.guest')

@section('title', 'Accueil - Data Center')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <h1>Plateforme de Gestion des Ressources du Data Center</h1>
            <p>Consultez les ressources informatiques disponibles et déposez une demande d'accès pour réserver : serveurs, machines virtuelles, stockage et équipements réseau.</p>
            <div class="hero-buttons">
                <a href="{{ route('catalogue') }}" class="btn btn-primary btn-large">Explorer les ressources</a>
                <a href="{{ route('demande.compte') }}" class="btn btn-outline btn-large">Demander un compte</a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Nos Services</h2>
            <p class="section-subtitle">Découvrez les ressources disponibles dans notre Data Center</p>
            
            <div class="card-grid">
                <div class="card">
                    <div class="card-icon">🖥️</div>
                    <h3>Serveurs Physiques</h3>
                    <p>Accédez à des serveurs physiques haute performance pour vos projets nécessitant des ressources dédiées et une puissance de calcul maximale.</p>
                </div>

                <div class="card">
                    <div class="card-icon">☁️</div>
                    <h3>Machines Virtuelles</h3>
                    <p>Déployez rapidement des machines virtuelles configurables selon vos besoins spécifiques en CPU, RAM et stockage.</p>
                </div>

                <div class="card">
                    <div class="card-icon">💾</div>
                    <h3>Stockage</h3>
                    <p>Bénéficiez de solutions de stockage sécurisées et performantes avec différentes options : SSD, HDD, NAS et SAN.</p>
                </div>

                <div class="card">
                    <div class="card-icon">🌐</div>
                    <h3>Équipements Réseau</h3>
                    <p>Utilisez nos équipements réseau professionnels : switches, routeurs, pare-feu pour vos architectures réseau.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section">
        <div class="container text-center">
            <h2 class="section-title">Prêt à commencer ?</h2>
            <p class="section-subtitle">Déposez votre demande de compte pour accéder aux ressources du Data Center</p>
            <div class="flex-center gap-2">
                <a href="{{ route('demande.compte') }}" class="btn btn-primary btn-large">Demander un compte</a>
                <a href="{{ route('regles') }}" class="btn btn-outline btn-large">Consulter les règles</a>
            </div>
        </div>
    </section>
 <!-- Footer détaillé -->

<style>
 .footer-detailed {
            background-color: #1e293b;
            color: #d1d5db;
            padding: 3rem 0;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @media (min-width: 768px) {
            .footer-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .footer-section h3 {
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .footer-section p {
            color: #9ca3af;
            line-height: 1.75;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: #ffffff;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .contact-item svg {
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
        }

        .icon-blue {
            color: #60a5fa;
        }

        .icon-pink {
            color: #f472b6;
        }

        .icon-red {
            color: #f87171;
        }

        .footer-divider {
            border-top: 1px solid #374151;
            margin-top: 2rem;
            padding-top: 1.5rem;
            text-align: center;
            color: #9ca3af;
        }
    </style>



    <footer class="footer-detailed">




        <div class="footer-container">
            <div class="footer-grid">
                <!-- Section Data Center -->
                <div class="footer-section">
                    <h3>Data Center</h3>
                    <p>
                        Plateforme de gestion et de réservation des ressources informatiques.
                    </p>
                </div>

                <!-- Section Liens rapides -->
                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <ul class="footer-links">
                        <li>
                            <a href="{{ url('/') }}">Accueil</a>
                        </li>
                        <li>
                            <a href="{{ url('/catalogue') }}">Catalogue des ressources</a>
                        </li>
                        <li>
                            <a href="{{ url('/regles') }}">Règles d'utilisation</a>
                        </li>
                        <li>
                            <a href="{{ url('/demande-compte') }}">Demander un compte</a>
                        </li>
                    </ul>
                </div>

                <!-- Section Support -->
                <div class="footer-section">
                    <h3>Support</h3>
                    <ul class="footer-links">
                        <li>
                            <a href="#">Documentation</a>
                        </li>
                        <li>
                            <a href="#">FAQ</a>
                        </li>
                        <li>
                            <a href="#">Contact</a>
                        </li>
                        <li>
                            <a href="#">Assistance technique</a>
                        </li>
                    </ul>
                </div>

                <!-- Section Contact -->
                <div class="footer-section">
                    <h3>Contact</h3>
                    <div class="contact-item">
                        <svg class="icon-blue" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        <a href="mailto:contact@datacenter.ma">contact@datacenter.ma</a>
                    </div>
                    <div class="contact-item">
                        <svg class="icon-pink" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        <a href="tel:+212521738852">+212 521738852</a>
                    </div>
                    <div class="contact-item">
                        <svg class="icon-red" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Casablanca, Maroc</span>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="footer-divider">
                <p>&copy; 2025 Data Center. Tous droits réservés.</p>
            </div>
        </div>

    </footer>
@endsection
    