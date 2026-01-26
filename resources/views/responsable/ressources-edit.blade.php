@extends('layouts.app')

@section('title', 'Modifier la ressource')

@push('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    :root {
        --primary: #3b82f6;
        --primary-hover: #2563eb;
        --bg-main: #f8fafc;
        --card-bg: #ffffff;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    .form-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 24px;
        transition: transform 0.2s;
    }

    .back-link:hover {
        transform: translateX(-5px);
    }

    .page-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 32px;
        letter-spacing: -0.025em;
    }

    .form-card {
        background: var(--card-bg);
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.8);
    }

    .form-section {
        margin-bottom: 40px;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid var(--bg-main);
    }

    .section-header h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .form-group label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .form-control {
        padding: 12px 16px;
        border-radius: 12px;
        border: 2px solid var(--border-color);
        background: #fdfdfd;
        font-size: 1rem;
        color: var(--text-dark);
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .specs-container {
        background: #f8fafc;
        border-radius: 20px;
        padding: 32px;
        border: 1px solid var(--border-color);
        margin-top: 10px;
    }

    .btn-submit {
        width: 100%;
        padding: 16px;
        border-radius: 16px;
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        color: #ffffff !important;
        border: none;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        margin-top: 20px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.4);
        background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%);
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-group.full-width {
            grid-column: span 1;
        }
    }
</style>
@endpush

@section('content')
    <div class="form-container">
        <a href="{{ route('responsable.ressources') }}" class="back-link">
            <span>←</span> Retour à la liste
        </a>
        
        <h1 class="page-title">Modifier : {{ $resource->nom }}</h1>

        <form class="form-card" method="POST" action="{{ route('responsable.ressources.update', $resource->id) }}">
            @csrf
            @method('PUT')

            <div class="form-section">
                <div class="section-header">
                    <span>📦</span>
                    <h2>Informations Générales</h2>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="categorie_id">Catégorie</label>
                        <select id="categorie_id" name="categorie_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('categorie_id', $resource->categorie_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nom">Nom de la ressource</label>
                        <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom', $resource->nom) }}" required maxlength="120">
                    </div>

                    <div class="form-group">
                        <label for="code_inv">Code Inventaire</label>
                        <input type="text" id="code_inv" name="code_inv" class="form-control" value="{{ old('code_inv', $resource->code_inv) }}" maxlength="60">
                    </div>

                    <div class="form-group">
                        <label for="emplacement">Emplacement</label>
                        <input type="text" id="emplacement" name="emplacement" class="form-control" value="{{ old('emplacement', $resource->emplacement) }}" maxlength="120">
                    </div>

                    <div class="form-group full-width">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control">{{ old('description', $resource->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-header">
                    <span>⚙️</span>
                    <h2>Caractéristiques Techniques</h2>
                </div>
                
                <div class="specs-container">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="cpu">Processeur (CPU)</label>
                            <input type="text" id="cpu" name="cpu" class="form-control" value="{{ old('cpu', $resource->cpu) }}">
                        </div>

                        <div class="form-group">
                            <label for="ram">Mémoire (RAM)</label>
                            <input type="text" id="ram" name="ram" class="form-control" value="{{ old('ram', $resource->ram) }}">
                        </div>

                        <div class="form-group">
                            <label for="os">Système d'Exploitation</label>
                            <input type="text" id="os" name="os" class="form-control" value="{{ old('os', $resource->os) }}">
                        </div>

                        <div class="form-group">
                            <label for="bande_passante">Bande passante</label>
                            <input type="text" id="bande_passante" name="bande_passante" class="form-control" value="{{ old('bande_passante', $resource->bande_passante) }}">
                        </div>

                        <div class="form-group">
                            <label for="capacite">Capacité Stockage</label>
                            <input type="text" id="capacite" name="capacite" class="form-control" value="{{ old('capacite', $resource->capacite) }}">
                        </div>

                        <div class="form-group">
                            <label for="type_stockage">Type de stockage</label>
                            <input type="text" id="type_stockage" name="type_stockage" class="form-control" value="{{ old('type_stockage', $resource->type_stockage) }}">
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">Mettre à jour la ressource</button>
        </form>
    </div>
@endsection
