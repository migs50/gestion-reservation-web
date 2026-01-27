

@extends('layouts.app')

@section('title', 'Tableau de bord Responsable')
@section('breadcrumb', 'Dashboard Responsable')

@section('content')
    
{{-- Page Header --}}
<div class="page-header">
    <div class="header-content">
        <h1 class="page-title"> Bonjour, {{ Auth::user()->nom }}</h1>
        <p class="page-subtitle">
            Vous gérez actuellement <strong>{{ $totalResources }}</strong> ressource(s) avec <strong>{{ $pendingRequests }}</strong> demande(s) en attente
        </p>
    </div>
</div>

{{-- Quick Stats --}}
<div class="quick-stats">
    <div class="stat-card" onclick="window.location.href='{{ route('responsable.ressources') }}'">
        <div class="stat-value">{{ $totalResources }}</div>
        <div class="stat-label">Mes ressources</div>
    </div>

    <div class="stat-card" onclick="window.location.href='{{ route('responsable.requests') }}'">
        <div class="stat-value">{{ $pendingRequests }}</div>
        <div class="stat-label">Demandes en attente</div>
    </div>

    <div class="stat-card">
        <div class="stat-value">{{ $approvedReservations }}</div>
        <div class="stat-label">Réservations actives</div>
    </div>

    <div class="stat-card" onclick="window.location.href='{{ route('responsable.discussions') }}'">
        <div class="stat-value"></div>
        <div class="stat-label">Modération</div>
    </div>
</div>

{{-- Main Dashboard Grid --}}
<div class="dashboard-grid">
    {{-- Pending Requests --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <span></span>
                <span>Demandes en attente</span>
            </h2>
            <span class="badge badge-warning">{{ $pendingRequests }} nouvelle(s)</span>
        </div>

        <div class="request-list">
            @forelse($requests as $request)
                <div class="request-item">
                    <div class="request-header">
                        <div class="request-info">
                            <h4>{{ $request->ressource->nom }}</h4>
                            <p>
                                <span></span>
                                <span>{{ $request->demandeur->nom }} {{ $request->demandeur->prenom }}</span>
                                <span>•</span>
                                <span>Du {{ $request->debut->format('d/m/Y') }} au {{ $request->fin->format('d/m/Y') }}</span>
                            </p>
                        </div>
                        <span class="request-status {{ ($request->is_urgent ?? false) ? 'status-urgent' : 'status-pending' }}">
                            {{ ($request->is_urgent ?? false) ? 'Urgent' : 'En attente' }}
                        </span>
                    </div>
                    <div class="request-actions">
                        <button type="button" class="btn-sm btn-approve" onclick="openApproveModal({{ $request->id }})">
                            Approuver
                        </button>
                        <button type="button" class="btn-sm btn-reject" onclick="openRejectModal({{ $request->id }})">
                            Refuser
                        </button>
                        <a href="{{ route('responsable.requests.show', $request->id) }}" class="btn-sm btn-view">
                             Détails
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon"></div>
                    <p>Aucune demande en attente</p>
                </div>
            @endforelse
        </div>

        @if($requests->count() > 0)
            <a href="{{ route('responsable.requests') }}" style="display: block; text-align: center; margin-top: 20px; color: #667eea; font-weight: 600; text-decoration: none;">
                Voir toutes les demandes →
            </a>
        @endif
    </div>

    {{-- Resources Overview --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">
                <span></span>
                <span>Vue d'ensemble</span>
            </h2>
            <span class="badge badge-info">{{ $totalResources }} total</span>
        </div>

        <div class="resource-summary">
            @foreach($resourcesByType as $type => $data)
                <div class="resource-item">
                    <div class="resource-header">
                        <span class="resource-name">{{ ucfirst($type) }}</span>
                        <span class="resource-count">{{ $data['total'] }}</span>
                    </div>
                    <div class="resource-bar">
                        <div class="resource-fill {{ $data['percentage'] >= 80 ? 'fill-high' : ($data['percentage'] >= 50 ? 'fill-medium' : 'fill-low') }}" 
                             style="width: {{ $data['percentage'] }}%"></div>
                    </div>
                    <div class="resource-info">
                        <span>{{ $data['percentage'] }}% utilisés</span>
                        <span>{{ $data['occupied'] }}/{{ $data['total'] }} occupés</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    // Animate stats on load
    window.addEventListener('load', () => {
        document.querySelectorAll('.stat-value').forEach((el, index) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                el.style.transition = 'all 0.5s ease-out';
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });

    // Auto-refresh every 30 seconds
    setTimeout(() => {
        location.reload();
    }, 30000);

    // Modal functions
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
    /* Styles pour les cartes de statistiques */
    .quick-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
        max-width: 800px; /* Limiter la largeur pour que ça reste élégant en 2x2 */
        margin-left: auto;
        margin-right: auto;
    }

    .stat-card {
        background: #ffffff !important;
        background-image: none !important;
        border-radius: 20px;
        padding: 40px 25px !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
        border: 1px solid #edf2f7 !important;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        border-color: #f9b17a !important;
    }

    .stat-value {
        font-size: 42px !important;
        font-weight: 800 !important;
        color: #2d3250 !important;
        margin: 0 0 10px 0 !important;
        opacity: 1 !important;
        transform: none !important;
        line-height: 1 !important;
    }

    .stat-label {
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #718096 !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        margin: 0 !important;
    }

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
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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

@endsection