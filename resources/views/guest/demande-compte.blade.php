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

## 🎯 Structure finale des contrôleurs
```
app/Http/Controllers/
│
├── Controller.php              (Base, déjà existant)
│
├── GuestController.php         ← NOUVEAU
│   ├── index()         → Page d'accueil
│   ├── catalogue()     → Catalogue ressources
│   └── regles()        → Règles d'utilisation
│
└── DemandeCompteController.php ← NOUVEAU
    ├── create()        → Afficher formulaire
    └── store()         → Traiter formulaire