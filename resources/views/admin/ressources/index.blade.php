@extends('layouts.admin')

@section('title', 'Ressources')

@section('content')
    <h1>Liste des ressources</h1>

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
                    <td>{{ $ressource->actif ? 'Oui' : 'Non' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Aucune ressource trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $ressources->links() }}
@endsection
