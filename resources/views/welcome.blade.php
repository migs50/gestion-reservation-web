<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Gestion Réservation') }}</title>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container" style="display:flex; justify-content:space-between; align-items:center; max-width:1200px; margin:0 auto; width:100%;">
            <a href="{{ url('/') }}" class="navbar-brand">
                <span class="logo-text">GESTION RÉSERVATION</span>
            </a>
            
            <div class="navbar-menu">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container" style="max-width:800px; margin:0 auto; padding: 2rem;">
            <h1>Bienvenue sur votre plateforme</h1>
            <p>Gérez vos réservations, signalements et ressources en toute simplicité. Une solution complète et intuitive pour votre organisation.</p>
            
            <div class="hero-buttons" style="display:flex; gap:1rem; justify-content:center; margin-top:2rem;">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-lg btn-primary">Accéder au Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-lg btn-primary">Se Connecter</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-lg btn-secondary">Créer un compte</a>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" style="padding: 4rem 2rem; background-color: var(--bg-primary);">
        <div class="container" style="max-width:1200px; margin:0 auto;">
            <div class="stats-grid">
                
                <!-- Feature 1 -->
                <div class="stat-card blue">
                    <div class="stat-header">
                        <div class="stat-icon">📅</div>
                    </div>
                    <h3 class="stat-value" style="font-size:1.5rem;">Réservations</h3>
                    <p class="stat-label">Planifiez vos ressources</p>
                </div>

                <!-- Feature 2 -->
                <div class="stat-card orange">
                    <div class="stat-header">
                        <div class="stat-icon">⚠️</div>
                    </div>
                    <h3 class="stat-value" style="font-size:1.5rem;">Incidents</h3>
                    <p class="stat-label">Signalez les problèmes</p>
                </div>

                <!-- Feature 3 -->
                <div class="stat-card green">
                    <div class="stat-header">
                        <div class="stat-icon">📊</div>
                    </div>
                    <h3 class="stat-value" style="font-size:1.5rem;">Suivi</h3>
                    <p class="stat-label">Visualisez les statistiques</p>
                </div>

                <!-- Feature 4 -->
                <div class="stat-card blue">
                    <div class="stat-header">
                        <div class="stat-icon">👤</div>
                    </div>
                    <h3 class="stat-value" style="font-size:1.5rem;">Gestion</h3>
                    <p class="stat-label">Administration complète</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container" style="max-width:1200px; margin:0 auto; text-align:center;">
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Gestion Réservation. Tous droits réservés.
                <p style="margin-top:1rem; font-size:0.9rem; opacity:0.7;">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </p>
            </div>
        </div>
    </footer>

</body>
</html>
