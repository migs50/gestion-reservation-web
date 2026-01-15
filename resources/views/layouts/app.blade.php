<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Accueil') - DataCenter Manager</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
            color: #333;
        }

        /* Header Navigation */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            height: 70px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }

        .navbar-brand span {
            margin-left: 10px;
        }

        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 5px;
            align-items: center;
        }

        .navbar-menu a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background 0.3s ease;
            font-size: 15px;
        }

        .navbar-menu a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .navbar-menu .btn-primary {
            background: white;
            color: #667eea;
            font-weight: 600;
        }

        .navbar-menu .btn-primary:hover {
            background: #f0f0f0;
        }

        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background: white;
            border-radius: 2px;
            transition: 0.3s;
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 40px 20px 20px;
            margin-top: 60px;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 20px;
        }

        .footer h4 {
            margin-bottom: 15px;
            font-size: 18px;
        }

        .footer ul {
            list-style: none;
        }

        .footer ul li {
            margin-bottom: 10px;
        }

        .footer a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: white;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #34495e;
            color: #bdc3c7;
            font-size: 14px;
        }

        /* Notification Badge */
        .notification-badge {
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 11px;
            margin-left: 5px;
            font-weight: bold;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
            }

            .navbar-menu {
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                flex-direction: column;
                padding: 20px;
                display: none;
            }

            .navbar-menu.active {
                display: flex;
            }

            .navbar-menu a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
    @stack('style')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('home') }}" class="navbar-brand">
                🖥️ <span>DataCenter Manager</span>
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
                    <li><a href="{{ route('demande.compte') }}">Inscription</a></li>
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
                <h4>DataCenter Manager</h4>
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