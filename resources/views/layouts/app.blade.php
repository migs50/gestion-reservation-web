<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Data Center - Gestion de Réservation')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('styles')
</head>
<body>
    <header>
        
                        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-logo">
                    <a href="/">Data Center Manager</a>
                </div>
                <ul class="nav-menu">

                    @guest
                        <li><a href="/">Accueil</a></li>
                        <li><a href="{{ route('login') }}">Connexion</a></li>
                        <li><a href="{{ route('register') }}">Demander un compte</a></li>
                    @else
                        <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                        <li><a href="{{ route('profile') }}">Mon profil</a></li>
                 @if(auth()->user()->hasAnyRole(['Admin', 'Responsable']))
                            <li><a href="{{ route('ressources.index') }}">Ressources</a></li>
                        @endif
                        @if(auth()->user()->hasRole('Admin'))
                            <li><a href="{{ route('admin.users') }}">Utilisateurs</a></li>
                        @endif
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-link">Déconnexion</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if(session('status'))
            <div class="alert alert-info">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

       {{-- Footer --}}
      

</html>
   
</body>
</html>
