<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Accueil') - DataCenter Manager</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- External CSS -->    
    @stack('style')

</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
                   <a href="{{ route('home') }}" class="navbar-brand">
                     <div class="brand-logo">
            <span class="brand-icon">DC</span>
            </div>
            <span class="brand-text">  Data Center</span>
        </a>

            <div class="menu-toggle" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="{{ route('home') }}">Accueil</a></li>
                <li><a href="{{ route('publique.ressources') }}">Ressources</a></li>
                <li><a href="{{ route('rules') }}">Règles</a></li>

                @guest
                    <li><a href="{{ route('login') }}" class="btn-primary">Connexion</a></li>
                    <li><a href="{{ route('register') }}">Inscription</a></li>
                @else
                    @auth
                    <li>
                       
                     <a href="{{ route('user.notifications') }}">
                            Notifications
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="notification-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                            @endif
                        </a>
                    </li>
                    @endauth
                    <li><a href="{{ route('user.incidents.index') }}">Mes Incidents</a></li>
                    <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none;border:none;padding:0;color:inherit;cursor:pointer;">
                                Déconnexion
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div>
                <h4>Data Center</h4>
                <p>Plateforme de gestion et réservation des ressources informatiques.</p>
            </div>
            <div>
                <h4>Liens rapides</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('publique.ressources') }}">Ressources</a></li>
                    <li><a href="{{ route('rules') }}">Règles d'utilisation</a></li>
                    @guest
                    <li><a href="{{ route('demande.compte') }}">Demander un compte</a></li>
                    @endguest
                    @auth
                    <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none;border:none;padding:0;color:inherit;cursor:pointer;">
                                Déconnexion
                            </button>
                        </form>
                    </li>
                    @endauth
                </ul>
            </div>
            <div>
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2026 DataCenter Manager. Tous droits réservés.
        </div>
    </footer>

    <script>
        // Toggle mobile menu
        function toggleMenu() {
            const menu = document.getElementById('navbarMenu');
            menu.classList.toggle('active');
        }
    </script>

    @stack('scripts')
</body>
</html>