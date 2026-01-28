@extends('layouts.app')

@section('title', 'Mes Notifications')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    .page-header {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-header h1 {
        font-size: 28px;
        color: #2c3e50;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .filters-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .filter-btn {
        padding: 12px 20px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        color: #6c757d;
    }

    .filter-btn:hover {
        border-color: #667eea;
        color: #667eea;
    }

    .filter-btn.active {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }

    .notifications-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .notification-item {
        padding: 25px;
        border-bottom: 1px solid #ecf0f1;
        display: flex;
        gap: 20px;
        transition: background 0.3s ease;
        cursor: pointer;
    }

    .notification-item:hover {
        background: #f8f9fa;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-item.unread {
        background: rgba(102, 126, 234, 0.05);
        border-left: 4px solid #667eea;
    }

    .notification-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .notification-icon.success {
        background: rgba(46, 204, 113, 0.1);
    }

    .notification-icon.danger {
        background: rgba(231, 76, 60, 0.1);
    }

    .notification-icon.warning {
        background: rgba(243, 156, 18, 0.1);
    }

    .notification-icon.info {
        background: rgba(52, 152, 219, 0.1);
    }

    .notification-content {
        flex: 1;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 8px;
    }

    .notification-title {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
    }

    .notification-time {
        font-size: 13px;
        color: #7f8c8d;
        white-space: nowrap;
    }

    .notification-message {
        color: #555;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .notification-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
        border-radius: 6px;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background: #5568d3;
    }

    .btn-link {
        background: transparent;
        color: #667eea;
        border: none;
        padding: 0;
        text-decoration: underline;
        cursor: pointer;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #7f8c8d;
    }

    .empty-state span {
        font-size: 64px;
        display: block;
        margin-bottom: 20px;
    }

    .pagination {
        padding: 25px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            gap: 15px;
        }

        .notification-item {
            flex-direction: column;
        }

        .notification-header {
            flex-direction: column;
            gap: 5px;
        }
    }
</style>

<!-- Header -->
<div class="page-header">
    <h1>Mes Notifications</h1>
</div>


<!-- Notifications List -->
<div class="notifications-container">
    @forelse($notifications as $notification)
    <div class="notification-item {{ !$notification->lu ? 'unread' : '' }}" 
         onclick="markAsRead({{ $notification->id }})">
        
        <div class="notification-icon {{ $notification->getTypeClass() }}">
        </div>

        <div class="notification-content">
            <div class="notification-header">
                <div class="notification-title">{{ $notification->titre }}</div>
                <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
            </div>

            <div class="notification-message">
                {{ $notification->contenu }}
            </div>

            @if($notification->lien)
                @if(auth()->user()->role->nom !== 'Responsable Technique')
                    <div class="notification-actions">
                        <a href="{{ $notification->lien }}" class="btn btn-primary btn-sm">
                             Voir détails
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>
    @empty
    <div class="empty-state">
        <span></span>
        <h3>Aucune notification</h3>
        <p>Vous n'avez pas de nouvelles notifications pour le moment</p>
    </div>
    @endforelse

    @if($notifications->hasPages())
    <div class="pagination">
        {{ $notifications->links() }}
    </div>
    @endif
</div>

<script>
function filterNotifications(type) {
    const url = new URL(window.location.href);
    if (type) {
        url.searchParams.set('type', type);
    } else {
        url.searchParams.delete('type');
    }
    window.location.href = url.toString();
}

function markAsRead(id) {
    fetch(`/notifications/${id}/mark-read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(response => {
        if (response.ok) {
            const item = event.currentTarget;
            item.classList.remove('unread');
        }
    });
}
</script>

@if(session('success'))
<script>
    alert('{{ session('success') }}');
</script>
@endif
@endsection