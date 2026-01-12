@extends('layouts.admin')

@section('title', 'Rôles & Permissions')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Gestion des Rôles</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="padding: 15px; background: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table class="table">
            <thead>
                <tr>
                    <th>Rôle</th>
                    <th>Utilisateurs</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>
                        <span class="badge badge-{{ $role->nom == 'Admin' ? 'danger' : ($role->nom == 'Responsable Technique' ? 'warning' : 'info') }}">
                            {{ $role->nom }}
                        </span>
                    </td>
                    <td>{{ $role->users_count }} utilisateurs</td>
                    <td>
                        @foreach($role->permissions->take(5) as $permission)
                            <span style="font-size: 11px; background: #f1f2f6; padding: 2px 6px; border-radius: 4px; margin-right: 2px;">{{ $permission->nom }}</span>
                        @endforeach
                        @if($role->permissions->count() > 5)
                            <small>+{{ $role->permissions->count() - 5 }} autres</small>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-primary">🔐 Gérer les permissions</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
