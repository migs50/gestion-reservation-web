@extends('layouts.admin')

@section('title', 'Gérer les Permissions')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div class="card">
    <div class="card-header">
        <h3>Permissions pour le rôle : {{ $role->nom }}</h3>
        <p style="color: #7f8c8d; font-size: 14px;">Cochez les actions autorisées pour ce rôle.</p>
    </div>

    <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px; margin-bottom: 30px;">
            @foreach($permissions as $permission)
            <div style="display: flex; align-items: center; gap: 10px; padding: 10px; background: #f8f9fa; border-radius: 6px;">
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}"
                    {{ $role->hasPermission($permission->nom) ? 'checked' : '' }}
                    style="width: 18px; height: 18px;">
                <label for="perm_{{ $permission->id }}" style="margin: 0; cursor: pointer;">{{ $permission->nom }}</label>
            </div>
            @endforeach
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="{{ route('admin.roles.index') }}" class="btn" style="background: #95a5a6; color: white;">Retour</a>
        </div>
    </form>
</div>
@endsection
