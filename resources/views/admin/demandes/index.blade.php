@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title" style="color: #424769;">Demandes de compte en attente</h3>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($demandes->isEmpty())
            <div class="empty-state">
                <p>Aucune demande en attente.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table" style="width: 100%; border-collapse: separate; border-spacing: 0 12px;">
                    <thead>
                        <tr style="background: rgba(0,0,0,0.1);">
                            <th style="width: 80px; padding: 15px; border-radius: 8px 0 0 8px;">ID</th>
                            <th style="padding: 15px;">Utilisateur</th>
                            <th style="padding: 15px;">Contact</th>
                            <th style="width: 140px; padding: 15px;">Type</th>
                            <th style="padding: 15px;">Justification</th>
                            <th style="width: 280px; padding: 15px; border-radius: 0 8px 8px 0; text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demandes as $demande)
                            <tr style="background: rgba(255,255,255,0.05); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                <td style="padding: 20px; border-radius: 8px 0 0 8px;">#{{ $demande->id }}</td>
                                <td style="padding: 20px;">
                                    <div style="font-weight: 700; color: var(--color-peach); font-size: 1.1em;">{{ $demande->nom_complet }}</div>
                                </td>
                                <td style="padding: 20px;">
                                    <div style="font-size: 0.95em; color: var(--text-primary);">{{ $demande->email }}</div>
                                    <div style="font-size: 0.85em; color: var(--text-muted); margin-top: 4px;">{{ $demande->telephone }}</div>
                                </td>
                                <td style="padding: 20px;">
                                    <span class="badge" style="background: var(--bg-tertiary); color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.8em; font-weight: 600;">
                                        {{ $demande->type_demande }}
                                    </span>
                                </td>
                                <td style="padding: 20px; max-width: 300px;">
                                    <div style="font-size: 0.9em; max-height: 100px; overflow-y: auto; white-space: normal; padding-right: 8px; line-height: 1.4; word-break: break-all;">
                                        {{ $demande->justification }}
                                    </div>
                                </td>
                                <td style="padding: 20px; border-radius: 0 8px 8px 0;">
                                    <div style="display: flex; gap: 12px; justify-content: center; align-items: center;">
                                        {{-- Accept --}}
                                        <form action="{{ route('admin.demandes.accept', $demande) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="btn" style="background-color: #2d3250; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 0.9em; transition: all 0.2s; cursor: pointer; box-shadow: 0 4px 6px rgba(46, 204, 113, 0.2);">
                                                Accepter
                                            </button>
                                        </form>
                                        
                                        {{-- Reject --}}
                                        <form action="{{ route('admin.demandes.reject', $demande) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" class="btn" style="background-color: #f9b17a; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 0.9em; transition: all 0.2s; cursor: pointer; box-shadow: 0 4px 6px rgba(231, 76, 60, 0.2);">
                                                Refuser
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
