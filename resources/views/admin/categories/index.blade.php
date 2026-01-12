@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Liste des Catégories</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">➕ Nouvelle Catégorie</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="padding: 15px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="padding: 15px; background: #f8d7da; color: #721c24; border-radius: 6px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>#{{ $category->id }}</td>
                    <td><strong>{{ $category->nom }}</strong></td>
                    <td>{{ Str::limit($category->description, 50) }}</td>
                    <td>{{ $category->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary" style="padding: 5px 10px; font-size: 12px;">Modifier</a>
                            
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" style="padding: 5px 10px; font-size: 12px;">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $categories->links() }}
    </div>
</div>
@endsection
