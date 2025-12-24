<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Data Center - Gestion des Ressources')</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <div class="logo-icon">DC</div>
                <span>Data Center</span>
            </a>
            <button class="menu-toggle" id="menuToggle">☰</button>
            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}" class="nav-link">Accueil</a></li>
                <li><a href="{{ route('catalogue') }}" class="nav-link">Ressources</a></li>
                <li><a href="{{ route('regles') }}" class="nav-link">Règles d'utilisation</a></li>
                <li><a href="{{ route('demande.compte') }}" class="nav-btn">Demander un compte</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenu principal -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h3>Data Center</h3>
                    <p>Plateforme de gestion et de réservation des ressources informatiques.</p>
                </div>

                <div class="footer-section">
                    <h3>Liens rapides</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                        <li><a href="{{ route('catalogue') }}">Catalogue des ressources</a></li>
                        <li><a href="{{ route('regles') }}">Règles d'utilisation</a></li>
                        <li><a href="{{ route('demande.compte') }}">Demander un compte</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Support</h3>
                    <ul class="footer-links">
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Assistance technique</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Contact</h3>
                    <ul class="footer-links">
                        <li>📧 contact@datacenter.ma</li>
                        <li>📞 +212 5XX-XXXXXX</li>
                        <li>📍 Casablanca, Maroc</li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Data Center. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Menu mobile toggle
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', () => navMenu.classList.toggle('active'));
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>