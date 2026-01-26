<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@extends('layouts.admin') {{-- or your admin layout --}}

@section('content')
<div class="container">
    <h1>Demandes de compte en attente</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($demandes->isEmpty())
        <p>Aucune demande en attente.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom complet</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Type</th>
                    <th>Justification</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($demandes as $demande)
                    <tr>
                        <td>{{ $demande->id }}</td>
                        <td>{{ $demande->nom_complet }}</td>
                        <td>{{ $demande->email }}</td>
                        <td>{{ $demande->telephone }}</td>
                        <td>{{ $demande->type_demande }}</td>
                        <td style="max-width: 250px;">{{ $demande->justification }}</td>
                        <td class="d-flex gap-2">
                            {{-- Accept --}}
                            <form action="{{ route('admin.demandes.accept', $demande) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    Accepter
                                </button>
                            </form>

                            {{-- Reject --}}
                            <form action="{{ route('admin.demandes.reject', $demande) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Refuser
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
