@extends('layouts.app')

@section('title', 'Détails de la demande - Responsable')

@push('style')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    :root {
        --primary: #4f46e5;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --bg-main: #f8fafc;
        --card-bg: #ffffff;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    .detail-container {
        max-width: 1000px;
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

    .detail-card {
        background: var(--card-bg);
        border-radius: 24px;
        padding: 0;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
    }

    .detail-header {
        padding: 40px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .header-info h1 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 8px;
        letter-spacing: -0.025em;
    }

    .header-info p {
        color: var(--text-muted);
        font-weight: 500;
    }

    .status-badge {
        padding: 8px 20px;
        border-radius: 999px;
        font-size: 0.875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-approved { background: #d1fae5; color: #065f46; }
    .status-rejected { background: #fee2e2; color: #991b1b; }

    .detail-body {
        padding: 40px;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .info-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .info-value {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .justification-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 24px;
        border-left: 4px solid var(--primary);
        font-style: italic;
        color: #475569;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .decision-panel {
        background: #fffaf0;
        border-radius: 20px;
        padding: 32px;
        border: 1px solid #feebc8;
        margin-top: 20px;
    }

    .decision-panel h3 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #92400e;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .note-textarea {
        width: 100%;
        padding: 16px;
        border-radius: 12px;
        border: 2px solid #cbd5e0;
        font-size: 1rem;
        transition: all 0.2s;
        margin-bottom: 20px;
    }

    .note-textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    .action-footer {
        display: flex;
        gap: 16px;
    }

    .btn-action {
        flex: 1;
        padding: 16px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-approve { background: var(--success); color: white; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); }
    .btn-reject { background: var(--danger); color: white; box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2); }

    .btn-approve:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3); }
    .btn-reject:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(239, 68, 68, 0.3); }

    @media (max-width: 640px) {
        .info-grid { grid-template-columns: 1fr; }
        .action-footer { flex-direction: column; }
    }
</style>
@endpush

@section('content')
<div class="detail-container">
    <a href="{{ route('responsable.requests') }}" class="back-link">
        ← Retour aux demandes
    </a>

    <div class="detail-card">
        <div class="detail-header">
            <div class="header-info">
                <h1>Demande #REQ-{{ $reservation->id }}</h1>
                <p>Soumise le {{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <span class="status-badge status-{{ $reservation->statut }}">
                {{ ucfirst($reservation->statut) }}
            </span>
        </div>

        <div class="detail-body">
            <div class="section-title">👤 Informations Demandeur</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nom Complet</span>
                    <span class="info-value">{{ $reservation->demandeur->nom }} {{ $reservation->demandeur->prenom }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email de contact</span>
                    <span class="info-value">{{ $reservation->demandeur->email }}</span>
                </div>
            </div>

            <div class="section-title">🖥️ Ressource Demandée</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nom de la ressource</span>
                    <span class="info-value">{{ $reservation->ressource->nom }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Catégorie technique</span>
                    <span class="info-value">{{ $reservation->ressource->categorie->nom ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="section-title">📅 Période de Réservation</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Date de Début</span>
                    <span class="info-value">{{ $reservation->debut->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date de Fin</span>
                    <span class="info-value">{{ $reservation->fin->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            @if($reservation->justification)
                <div class="section-title">📝 Justification de l'utilisateur</div>
                <div class="justification-box">
                    "{{ $reservation->justification }}"
                </div>
            @endif

            @if($reservation->statut === 'pending')
                <div class="decision-panel">
                    <h3>🏁 Prendre une décision</h3>
                    
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #4b5563; margin-bottom: 10px;">Note de décision (Optionnelle pour approbation, obligatoire pour refus)</label>
                        <textarea id="note_decision" name="note_decision" class="note-textarea" rows="3" placeholder="Saisissez ici le motif du refus ou une note d'approbation..."></textarea>
                    </div>

                    <div class="action-footer">
                        <form action="{{ route('responsable.requests.approve', $reservation->id) }}" method="POST" style="flex: 1;" id="approve-form">
                            @csrf
                            <input type="hidden" name="note_decision" id="note-approve">
                            <button type="submit" class="btn-action btn-approve" onclick="document.getElementById('note-approve').value = document.getElementById('note_decision').value; return confirm('Confirmer l\'approbation ?')">
                                <span>✓</span> Approuver
                            </button>
                        </form>
                        <form action="{{ route('responsable.requests.reject', $reservation->id) }}" method="POST" style="flex: 1;" id="reject-form">
                            @csrf
                            <input type="hidden" name="note_decision" id="note-reject">
                            <button type="submit" class="btn-action btn-reject" onclick="document.getElementById('note-reject').value = document.getElementById('note_decision').value; if(!document.getElementById('note-reject').value){alert('Veuillez saisir une justification pour le refus.'); return false;} return confirm('Confirmer le refus ?')">
                                <span>✗</span> Refuser
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($reservation->note_decision)
                 <div class="section-title">📢 Note de décision enregistrée</div>
                 <div class="justification-box" style="border-left-color: #94a3b8; background: #f1f5f9;">
                    {{ $reservation->note_decision }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
