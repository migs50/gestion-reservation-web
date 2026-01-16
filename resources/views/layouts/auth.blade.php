<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentification') - Data Center</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- External CSS -->
    

</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1>Data Center</h1>
            <p>@yield('subtitle', 'Gestion des ressources informatiques')</p>
        </div>

        <div class="auth-body">
            @yield('content')
        </div>

        <div class="auth-footer">
            @yield('footer')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
