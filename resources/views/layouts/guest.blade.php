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
                <li><a href="{{ route('login') }}" class="nav-btn">connexion</a></li>

            </ul>
        </div>
    </nav>

    <!-- Contenu principal -->
    @yield('content')

    <!-- Footer -->

 <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        /* Footer simple */
        .footer-simple {
            background-color: #1e293b;
            color: #9ca3af;
            padding: 1.5rem 0;
            margin-top: auto;
        }

        .footer-simple-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            text-align: center;
        }
    </style>

    <footer class="footer-simple">
        <div class="footer-simple-container">
            <p>&copy; 2025 Data Center. Tous droits réservés.</p>
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