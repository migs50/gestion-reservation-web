<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - Data Center </title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('style')

 

</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div style="font-size: 40px;"></div>
            <h2>Admin Panel</h2>
        </div>


            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span></span> Tableau de Bord
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.statistics') }}" class="{{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
                        <span></span> Statistiques
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.ressources.index') }}" class="{{ request()->routeIs('admin.ressources.*') ? 'active' : '' }}">
                        <span></span> Ressources
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <span></span> Catégories
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <span></span> Utilisateurs
                    </a>
                </li>


                <li>
                    <a href="{{ route('admin.reservations.index') }}" class="{{ request()->routeIs('admin.reservations.index') ? 'active' : '' }}">
                        <span></span> Réservations
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.reservations.decisions') }}" class="{{ request()->routeIs('admin.reservations.decisions') ? 'active' : '' }}">
                        <span></span> Décisions Responsables
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.maintenances.index') }}" class="{{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">
                        <span></span> Maintenance
                    </a>
                </li>

                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-logout-link">
                            <span></span> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Top Bar -->
        <div class="topbar">
            <div class="topbar-left">
                <span class="menu-toggle" onclick="toggleSidebar()">Menu</span>
                <h1>@yield('title', 'Administration')</h1>
            </div>

            <div class="topbar-right">

                <div class="user-info">
                    <div class="user-avatar">A</div>
                    <div>
                        <div style="font-weight: 600; font-size: 14px;">Admin</div>
                        <div style="font-size: 12px; color: #676f9d;">Administrateur</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>

    @stack('scripts')
</body>
</html>