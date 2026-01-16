@extends('layouts.admin')

@section('title', 'Ressources')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <h1 style="margin-bottom: 20px; color: #2c3e50;">Liste des ressources</h1>

    <a href="{{ route('admin.ressources.create') }}" class="btn btn-primary">
        Nouvelle ressource
    </a>
    <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Manager</th>
            <th>État</th>
            <th>Actif</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($ressources as $ressource)
            <tr>
                <td>#{{ $ressource->id }}</td>
                <td>{{ $ressource->nom }}</td>
                <td>{{ $ressource->categorie->nom ?? 'N/A' }}</td>
                <td>{{ $ressource->manager->nom ?? '-' }} {{ $ressource->manager->prenom ?? '' }}</td>
                <td>{{ $ressource->etat }}</td>
                <td>
                    <span class="badge {{ $ressource->actif ? 'badge-success' : 'badge-danger' }}">
                        {{ $ressource->actif ? 'Oui' : 'Non' }}
                    </span>
                </td>
                <td>
                    {{-- Bouton modifier --}}
                    <a href="{{ route('admin.ressources.edit', $ressource) }}"
                       class="btn btn-warning btn-sm">
                        Modifier
                    </a>

                    {{-- Bouton Activer / Désactiver --}}
                    <form action="{{ route('admin.ressources.toggleActif', $ressource) }}"
                          method="POST"
                          style="display:inline-block;">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="btn btn-sm {{ $ressource->actif ? 'btn-danger' : 'btn-success' }}">
                            {{ $ressource->actif ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center;">Aucune ressource trouvée.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $ressources->links() }}


    
@endsection
