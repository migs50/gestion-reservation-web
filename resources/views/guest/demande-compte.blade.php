<!-- Au début de la page, après @section('content') -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Formulaire -->
<form id="requestForm" class="form-container" method="POST" action="{{ route('demande.compte.store') }}">
    @csrf

    <!-- Vos champs de formulaire existants -->
    <!-- ... -->
</form>
```
<!-- Footer simple pour catalogue.blade.php, regles.blade.php, demande-compte.blade.php -->

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