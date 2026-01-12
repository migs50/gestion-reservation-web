@extends('layouts.app')

@section('title', 'Mes signalements')

@section('content')
<style>
    .page-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .badge-open { background: #fff9e6; color: #f1c40f; }
    .badge-in_progress { background: #eef2ff; color: #4f46e5; }
    .badge-resolved { background: #e3fcef; color: #00b894; }
    .badge-closed { background: #f1f2f6; color: #636e72; }
</style>

<div class="page-header">
    <h1>Mes signalements d'incidents</h1>
    <a href="{{ route('user.incidents.create') }}" class="btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none;">
        ➕ Signaler un problème
    </a>
</div>

<div class="glass-card" style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
    @if($incidents->isEmpty())
        <div style="text-align: center; padding: 40px;">
            <div style="font-size: 50px;">⚠️</div>
            <h3>Aucun incident signalé</h3>
            <p>Utilisez le bouton ci-dessus pour signaler un problème technique.</p>
        </div>
    @else
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #f8f9fa;">
                    <th style="padding: 15px;">Titre</th>
                    <th style="padding: 15px;">Ressource</th>
                    <th style="padding: 15px;">Statut</th>
                    <th style="padding: 15px;">Date</th>
                    <th style="padding: 15px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incidents as $incident)
                <tr style="border-bottom: 1px solid #f8f9fa;">
                    <td style="padding: 15px; font-weight: 600;">{{ $incident->titre }}</td>
                    <td style="padding: 15px;">{{ $incident->ressource->nom ?? 'Général' }}</td>
                    <td style="padding: 15px;">
                        <span class="badge badge-{{ $incident->statut }}" style="padding: 5px 12px; border-radius: 12px; font-size: 12px; font-weight: 700;">
                            {{ ucfirst($incident->statut == 'in_progress' ? 'En cours' : ($incident->statut == 'resolved' ? 'Résolu' : ($incident->statut == 'open' ? 'Ouvert' : 'Fermé'))) }}
                        </span>
                    </td>
                    <td style="padding: 15px;">{{ $incident->created_at->format('d/m/Y') }}</td>
                    <td style="padding: 15px;">
                        <a href="{{ route('user.incidents.show', $incident) }}" style="color: #667eea; text-decoration: none; font-weight: 600;">Détails</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 20px;">
            {{ $incidents->links() }}
        </div>
    @endif
</div>
@endsection
