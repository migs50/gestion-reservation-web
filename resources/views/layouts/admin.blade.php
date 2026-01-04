<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration') - DataCenter Manager</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #2c3e50;
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 25px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 20px;
            margin-top: 10px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-menu li {
            margin: 5px 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left: 4px solid #667eea;
        }

        .sidebar-menu a span {
            margin-right: 12px;
            font-size: 20px;
        }

        /* Main Content */
        .main-wrapper {
            flex: 1;
            margin-left: 260px;
            transition: margin-left 0.3s ease;
        }

        .topbar {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 24px;
        }

        .topbar h1 {
            font-size: 24px;
            color: #2c3e50;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
            font-size: 20px;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content {
            padding: 30px;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .card-header h3 {
            font-size: 20px;
            color: #2c3e50;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .stat-icon.blue {
            background: rgba(102, 126, 234, 0.1);
        }

        .stat-icon.green {
            background: rgba(46, 204, 113, 0.1);
        }

        .stat-icon.orange {
            background: rgba(230, 126, 34, 0.1);
        }

        .stat-icon.red {
            background: rgba(231, 76, 60, 0.1);
        }

        .stat-details h4 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .stat-details p {
            color: #7f8c8d;
            font-size: 14px;
        }

        /* Buttons */
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-success {
            background: #2ecc71;
            color: white;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Badge */
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div style="font-size: 40px;">🖥️</div>
            <h2>Admin Panel</h2>
        </div>

        {{-- <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span>📊</span> Tableau de bord
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <span>👥</span> Utilisateurs
                </a>
            </li>
            <li>
                <a href="{{ route('admin.ressources') }}" class="{{ request()->routeIs('admin.ressources') ? 'active' : '' }}">
                    <span>💾</span> Ressources
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                    <span>📁</span> Catégories
                </a>
            </li>
            <li>
                <a href="{{ route('admin.statistics') }}" class="{{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
                    <span>📈</span> Statistiques
                </a>
            </li>
            <li>
                <a href="{{ route('admin.maintenance') }}" class="{{ request()->routeIs('admin.maintenance') ? 'active' : '' }}">
                    <span>🔧</span> Maintenance
                </a>
            </li>
            <li>
                <a href="{{ route('home') }}">
                    <span>🏠</span> Retour au site
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <span>🚪</span> Déconnexion
                </a>
            </li>
        </ul> --}}

                    <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <span>📊</span> Tableau de bord
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.ressources.create') }}" class="{{ request()->routeIs('admin.ressources.create') ? 'active' : '' }}">
                        <span>💾</span> Ajouter ressource
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.reservations.index') }}" class="{{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                        <span>📋</span> Réservations
                    </a>
                </li>

                <li>
                    <a href="{{ route('home') }}">
                        <span>🏠</span> Retour au site
                    </a>
                </li>

                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" style="background:none;border:none;padding:0;color:inherit;cursor:pointer;">
                            <span>🚪</span> Déconnexion
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
                <span class="menu-toggle" onclick="toggleSidebar()">☰</span>
                <h1>@yield('title', 'Administration')</h1>
            </div>

            <div class="topbar-right">
                <div class="notification-icon">
                    🔔
                    <span class="notification-badge">5</span>
                </div>

                <div class="user-info">
                    <div class="user-avatar">A</div>
                    <div>
                        <div style="font-weight: 600; font-size: 14px;">Admin</div>
                        <div style="font-size: 12px; color: #7f8c8d;">Administrateur</div>
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