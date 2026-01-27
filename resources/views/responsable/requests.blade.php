

@extends('layouts.app')

@section('title', 'Demandes de Réservation - Responsable')
@section('breadcrumb', 'Demandes de Réservation')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    /* [Styles identiques au fichier précédent] */
    .page-header {
        background: linear-gradient(135deg, #424769 0%, #2d3250 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        color: white;
        display: flex;
        align-items: center;
        gap: 15px;
        margin: 0;
    }

    .stats-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-box {
        background: white;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        text-align: center;
        transition: all 0.3s;
    }

    .stat-box:hover {
        transform: translateY(-5px);
    }

    .stat-number {
        font-size: 36px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .stat-number.pending { color: #ed8936; }
    .stat-number.approved { color: #48bb78; }
    .stat-number.rejected { color: #f56565; }
    .stat-number.total { color: #4299e1; }

    .stat-label {
        font-size: 14px;
        color: #718096;
        font-weight: 600;
    }

    .filters-bar {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .filters-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 15px;
        align-items: end;
    }

    .filter-input, .filter-select {
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
    }

    .btn-filter {
        padding: 12px 20px;
        background: #2d3250;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
    }

    .requests-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .request-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        border-left: 5px solid #ed8936;
    }

    .request-card:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transform: translateX(5px);
    }

    .request-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f7fafc;
    }

    .request-title {
        font-size: 20px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .request-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 14px;
        color: #718096;
    }

    .request-status {
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }

    .status-pending {
        background: rgba(237, 137, 54, 0.12);
        color: #ed8936;
    }

    .status-approved {
        background: rgba(72, 187, 120, 0.12);
        color: #48bb78;
    }

    .status-rejected {
        background: rgba(245, 101, 101, 0.12);
        color: #f56565;
    }

    .status-urgent {
        background: rgba(245, 101, 101, 0.12);
        color: #f56565;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .request-message {
        background: #f7fafc;
        border-left: 4px solid #4299e1;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .message-header {
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .message-text {
        color: #4a5568;
        font-size: 14px;
        line-height: 1.6;
    }

    .request-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-approve {
        background: #48bb78;
        color: white;
        flex: 1;
    }

    .btn-reject {
        background: #f56565;
        color: white;
        flex: 1;
    }

    .btn-details {
        background: #f9b17a;
        color: white;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .filters-row {
            grid-template-columns: 1fr;
        }
        .request-actions {
            flex-direction: column;
        }
    }
</style>

{{-- Page Header --}}
<div class="page-header">
    <h1 class="page-title">
        <span></span>
        Demandes de Réservation
    </h1>
</div>

{{-- Stats Summary --}}
<div class="stats-summary">
    <div class="stat-box">
        <div class="stat-number pending">{{ $stats['pending'] }}</div>
        <div class="stat-label">En attente</div>
    </div>
    <div class="stat-box">
        <div class="stat-number approved">{{ $stats['approved'] }}</div>
        <div class="stat-label">Approuvées</div>
    </div>
    <div class="stat-box">
        <div class="stat-number rejected">{{ $stats['rejected'] }}</div>
        <div class="stat-label">Refusées</div>
    </div>
    <div class="stat-box">
        <div class="stat-number total">{{ $stats['total'] }}</div>
        <div class="stat-label">Total</div>
    </div>
</div>

{{-- Filters --}}
<div class="filters-bar">
    <form action="{{ route('responsable.requests') }}" method="GET">
        <div class="filters-row">
            <input 
                type="text" 
                name="search"
                class="filter-input" 
                placeholder="Utilisateur, ressource, ID..."
                value="{{ request('search') }}"
            >

            <select name="status" class="filter-select">
                <option value="">Tous les statuts</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvé</option>
                <option value="refused" {{ request('status') == 'refused' ? 'selected' : '' }}>Refusé</option>
            </select>

            <select name="urgent" class="filter-select">
                <option value="">Toutes</option>
                <option value="1" {{ request('urgent') == '1' ? 'selected' : '' }}>Urgentes</option>
                <option value="0" {{ request('urgent') == '0' ? 'selected' : '' }}>Normales</option>
            </select>

            <button type="submit" class="btn-filter">
                Filtrer
            </button>
        </div>
    </form>
</div>

{{-- Requests List --}}
<div class="requests-container">
    @forelse($requests as $request)
        <div class="request-card">
            <div class="request-header">
                <div>
                    <div class="request-title">
                        {{ $request->ressource->nom }}
                        <span style="font-size: 14px; color: #a0aec0; font-weight: 600;">#REQ-{{ $request->id }}</span>
                    </div>
                    <div class="request-meta">
                        <span> {{ $request->demandeur->nom }} {{ $request->demandeur->prenom }}</span>
                        <span>•</span>
                        <span> Du {{ $request->debut->format('d/m/Y') }} au {{ $request->fin->format('d/m/Y') }}</span>
                        <span>•</span>
                        <span> {{ $request->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <span class="request-status status-{{ $request->statut }}">
                    {{ ucfirst($request->statut) }}
                </span>
            </div>

            @if($request->justification)
                <div class="request-message">
                    <div class="message-header"> Justification de l'utilisateur</div>
                    <p class="message-text">{{ $request->justification }}</p>
                </div>
            @endif

            <div class="request-actions">
                @if($request->statut === 'pending')
                    <button type="button" class="action-btn btn-approve" onclick="openApproveModal({{ $request->id }})" style="flex: 1; width: 100%;">
                        <span></span>
                        <span>Approuver</span>
                    </button>

                    <button type="button" class="action-btn btn-reject" onclick="openRejectModal({{ $request->id }})" style="flex: 1; width: 100%;">
                        <span></span>
                        <span>Refuser</span>
                    </button>
                @endif

                <a href="{{ route('responsable.requests.show', $request->id) }}" class="action-btn btn-details" style="{{ $request->statut !== 'pending' ? 'flex: 1; justify-content: center;' : '' }}">
                    <span></span>
                    <span>Détails complets</span>
                </a>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 60px; background: white; border-radius: 15px;">
            <div style="font-size: 80px; margin-bottom: 20px;"></div>
            <h3 style="font-size: 24px; font-weight: 700; color: #2d3748; margin-bottom: 10px;">Aucune demande trouvée</h3>
            <p style="color: #718096; font-size: 16px;">Toutes les demandes ont été traitées ou aucune ne correspond aux filtres</p>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($requests->hasPages())
    <div style="margin-top: 30px;">
        {{ $requests->appends(request()->query())->links() }}
    </div>
@endif

{{-- Modal d'approbation --}}
<div id="approveModal" class="decision-modal" style="display: none;">
    <div class="modal-overlay" onclick="closeApproveModal()"></div>
    <div class="modal-container">
        <div class="modal-header">
            <h3>Approuver la demande</h3>
            <button class="modal-close" onclick="closeApproveModal()">×</button>
        </div>
        <form id="approveForm" method="POST">
            @csrf
            <div class="modal-body">
                <label for="approve_justification" class="form-label">Justification (optionnelle)</label>
                <textarea 
                    id="approve_justification" 
                    name="note_decision" 
                    class="form-textarea"
                    rows="4"
                    placeholder="Vous pouvez ajouter une note pour expliquer votre décision..."
                ></textarea>
                <p class="form-hint">Cette note sera envoyée à l'utilisateur et aux administrateurs.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeApproveModal()">Annuler</button>
                <button type="submit" class="btn-modal-submit btn-modal-approve">Approuver la demande</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal de refus --}}
<div id="rejectModal" class="decision-modal" style="display: none;">
    <div class="modal-overlay" onclick="closeRejectModal()"></div>
    <div class="modal-container">
        <div class="modal-header">
            <h3>Refuser la demande</h3>
            <button class="modal-close" onclick="closeRejectModal()">×</button>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="modal-body">
                <label for="reject_justification" class="form-label">Justification (requise) *</label>
                <textarea 
                    id="reject_justification" 
                    name="note_decision" 
                    class="form-textarea"
                    rows="4"
                    required
                    placeholder="Veuillez expliquer pourquoi vous refusez cette demande..."
                ></textarea>
                <p class="form-hint">Cette justification sera envoyée à l'utilisateur et aux administrateurs.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeRejectModal()">Annuler</button>
                <button type="submit" class="btn-modal-submit btn-modal-reject">Refuser la demande</button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Modal Styles */
    .decision-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
    }

    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }

    .modal-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        width: 90%;
        max-width: 550px;
        animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translate(-50%, -45%);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 25px 30px;
        border-bottom: 2px solid #f7fafc;
    }

    .modal-header h3 {
        font-size: 22px;
        font-weight: 800;
        color: #2d3748;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 32px;
        color: #a0aec0;
        cursor: pointer;
        transition: all 0.2s;
        line-height: 1;
        padding: 0;
        width: 32px;
        height: 32px;
    }

    .modal-close:hover {
        color: #2d3748;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 30px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .form-textarea {
        width: 100%;
        padding: 15px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
        transition: all 0.3s;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #2d3250;
        box-shadow: 0 0 0 3px rgba(45, 50, 80, 0.1);
    }

    .form-hint {
        margin-top: 10px;
        font-size: 13px;
        color: #718096;
        font-style: italic;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        padding: 20px 30px 30px;
    }

    .btn-modal-cancel {
        padding: 12px 24px;
        background: #f7fafc;
        color: #4a5568;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-modal-cancel:hover {
        background: #e2e8f0;
    }

    .btn-modal-submit {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        color: white;
    }

    .btn-modal-approve {
        background: #48bb78;
    }

    .btn-modal-approve:hover {
        background: #38a169;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(72, 187, 120, 0.3);
    }

    .btn-modal-reject {
        background: #f56565;
    }

    .btn-modal-reject:hover {
        background: #e53e3e;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(245, 101, 101, 0.3);
    }
</style>

<script>
    let currentRequestId = null;

    function openApproveModal(requestId) {
        currentRequestId = requestId;
        const modal = document.getElementById('approveModal');
        const form = document.getElementById('approveForm');
        form.action = `/responsable/requests/${requestId}/approve`;
        modal.style.display = 'block';
        document.getElementById('approve_justification').focus();
    }

    function closeApproveModal() {
        const modal = document.getElementById('approveModal');
        modal.style.display = 'none';
        document.getElementById('approve_justification').value = '';
        currentRequestId = null;
    }

    function openRejectModal(requestId) {
        currentRequestId = requestId;
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        form.action = `/responsable/requests/${requestId}/reject`;
        modal.style.display = 'block';
        document.getElementById('reject_justification').focus();
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.style.display = 'none';
        document.getElementById('reject_justification').value = '';
        currentRequestId = null;
    }

    // Fermer avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeApproveModal();
            closeRejectModal();
        }
    });
</script>

@endsection