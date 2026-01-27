@extends('layouts.app')

@section('title', 'Incidents sur mes ressources')

@section('content')
<div class="container" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
    
    <div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #818285ff; margin-bottom: 10px;">Incidents Signalés</h1>
            <p style="color: #6c757d;">Gestion des problèmes techniques sur vos ressources</p>
        </div>
        <a href="{{ route('responsable.ressources') }}" class="btn-primary" style="background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%); color: white; padding: 12px 25px; border-radius: 12px; text-decoration: none; font-weight: 600;">
            ← Retour Gestion
        </a>
    </div>

    <div style="background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); padding: 30px;">
        @if($incidents->isEmpty())
            <div style="text-align: center; padding: 60px 20px;">
                <div style="font-size: 48px; margin-bottom: 20px; color: #cbd5e0;">✅</div>
                <h3 style="color: #4a5568; margin-bottom: 10px;">Aucun incident en cours</h3>
                <p style="color: #718096;">Tout fonctionne parfaitement sur vos ressources !</p>
            </div>
        @else
            <table style="width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr style="text-align: left;">
                        <th style="padding: 15px; border-bottom: 2px solid #edf2f7; color: #4a5568; font-weight: 700;">Statut</th>
                        <th style="padding: 15px; border-bottom: 2px solid #edf2f7; color: #4a5568; font-weight: 700;">Titre</th>
                        <th style="padding: 15px; border-bottom: 2px solid #edf2f7; color: #4a5568; font-weight: 700;">Ressource</th>
                        <th style="padding: 15px; border-bottom: 2px solid #edf2f7; color: #4a5568; font-weight: 700;">Signalé par</th>
                        <th style="padding: 15px; border-bottom: 2px solid #edf2f7; color: #4a5568; font-weight: 700;">Date</th>
                        <th style="padding: 15px; border-bottom: 2px solid #edf2f7; color: #4a5568; font-weight: 700;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($incidents as $incident)
                        <tr>
                            <td style="padding: 15px; border-bottom: 1px solid #edf2f7;">
                                @php
                                    $statusColors = [
                                        'open' => ['bg' => '#fffaf0', 'c' => '#ed8936'],
                                        'in_progress' => ['bg' => '#ebf8ff', 'c' => '#4299e1'],
                                        'resolved' => ['bg' => '#f0fff4', 'c' => '#48bb78'],
                                        'closed' => ['bg' => '#edf2f7', 'c' => '#718096'],
                                    ];
                                    $s = $statusColors[$incident->statut] ?? $statusColors['open'];
                                    
                                    $labels = [
                                        'open' => 'OUVERT',
                                        'in_progress' => 'EN COURS',
                                        'resolved' => 'RÉSOLU',
                                        'closed' => 'FERMÉ'
                                    ];
                                @endphp
                                <span style="background: {{ $s['bg'] }}; color: {{ $s['c'] }}; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 0.8rem; letter-spacing: 0.5px;">
                                    {{ $labels[$incident->statut] }}
                                </span>
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #edf2f7; font-weight: 600; color: #2d3748;">
                                {{ $incident->titre }}
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #edf2f7;">
                                <a href="{{ route('responsable.ressources.edit', $incident->ressource) }}" style="color: #4f46e5; text-decoration: none; font-weight: 600;">
                                    {{ $incident->ressource->nom }}
                                </a>
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #edf2f7;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 30px; height: 30px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #4a5568; font-size: 0.8rem;">
                                        {{ substr($incident->declarant->prenom, 0, 1) }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.9rem;">{{ $incident->declarant->nom }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #edf2f7; color: #718096; font-size: 0.9rem;">
                                {{ $incident->created_at->format('d/m/Y') }}
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #edf2f7;">
                                <a href="{{ route('user.incidents.show', $incident) }}" style="color: #4a5568; text-decoration: none; font-weight: 600; padding: 6px 12px; background: #f7fafc; border-radius: 8px; font-size: 0.9rem; transition: all 0.2s; display: inline-block;">
                                    Voir détails
                                </a>
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
</div>
@endsection
