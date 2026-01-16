

@extends('layouts.admin')

@section('title', 'Maintenance Système')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .maintenance-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    .maintenance-card {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    .maintenance-card:hover {
        transform: translateY(-5px);
    }
    .maintenance-card h3 {
        margin-bottom: 15px;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .maintenance-card p {
        color: #7f8c8d;
        font-size: 14px;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    .status-indicator {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 8px;
    }
    .status-ok { background: #48bb78; }
    .status-warning { background: #f39c12; }
    .status-error { background: #e74c3c; }
    .log-viewer {
        background: #2c3e50;
        color: #ecf0f1;
        padding: 20px;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: 13px;
        max-height: 400px;
        overflow-y: auto;
        margin-top: 15px;
    }
    .log-line {
        padding: 5px 0;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .log-error { color: #e74c3c; }
    .log-warning { color: #f39c12; }
    .log-info { color: #3498db; }
    .log-success { color: #48bb78; }
    .backup-list {
        list-style: none;
        padding: 0;
        margin: 15px 0;
    }
    .backup-item {
        padding: 12px;
        background: #f8f9fa;
        margin-bottom: 8px;
        border-radius: 6px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .backup-item:hover {
        background: #e9ecef;
    }
    .system-info-table {
        width: 100%;
        margin-top: 15px;
    }
    .system-info-table td {
        padding: 10px;
        border-bottom: 1px solid #ecf0f1;
    }
    .system-info-table td:first-child {
        font-weight: 600;
        color: #2c3e50;
        width: 40%;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert-warning {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<div class="page-header">
    <h2>🔧 Maintenance Système</h2>
    <span class="badge badge-success">Système opérationnel</span>
</div>

@if(session('success'))
<div class="alert alert-success">
    <span style="font-size: 20px;">✓</span>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    <span style="font-size: 20px;">✗</span>
    <span>{{ session('error') }}</span>
</div>
@endif

<!-- Actions de maintenance -->
<div class="maintenance-grid">
    <!-- Cache -->
    <div class="maintenance-card">
        <h3>
            <span>🗑️</span>
            <span>Gestion du Cache</span>
        </h3>
        <p>Vider le cache de l'application pour forcer le rechargement des données et configurations.</p>
        
        <div style="margin-bottom: 15px;">
            <span class="status-indicator status-ok"></span>
            <strong>Cache actif</strong> ({{ $cache_size ?? '0 MB' }})
        </div>

        <form action="{{ route('admin.maintenance.clear-cache') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-warning" onclick="return confirm('Vider le cache ?')">
                🗑️ Vider le cache
            </button>
        </form>
        
        <button type="button" class="btn btn-secondary" onclick="refreshCacheInfo()">
            🔄 Actualiser
        </button>
    </div>

    <!-- Base de données -->
    <div class="maintenance-card">
        <h3>
            <span>🗄️</span>
            <span>Base de données</span>
        </h3>
        <p>Optimiser les tables de la base de données et vérifier l'intégrité des données.</p>
        
        <table class="system-info-table">
            <tr>
                <td>Taille DB:</td>
                <td><strong>{{ $db_size ?? '0 MB' }}</strong></td>
            </tr>
            <tr>
                <td>Tables:</td>
                <td><strong>{{ $tables_count ?? 0 }}</strong></td>
            </tr>
            <tr>
                <td>Connexion:</td>
                <td>
                    <span class="status-indicator status-ok"></span>
                    <strong>Active</strong>
                </td>
            </tr>
        </table>

        <form action="{{ route('admin.maintenance.optimize-db') }}" method="POST" style="margin-top: 15px;">
            @csrf
            <button type="submit" class="btn btn-primary" onclick="return confirm('Optimiser la base de données ?')">
                ⚡ Optimiser DB
            </button>
        </form>
    </div>

    <!-- Logs système -->
    <div class="maintenance-card">
        <h3>
            <span>📝</span>
            <span>Logs Système</span>
        </h3>
        <p>Consulter et gérer les fichiers de logs pour le débogage et l'audit.</p>
        
        <div style="margin-bottom: 15px;">
            <span class="status-indicator {{ $logs_warning ? 'status-warning' : 'status-ok' }}"></span>
            <strong>{{ $logs_count ?? 0 }} fichiers</strong> ({{ $logs_size ?? '0 MB' }})
        </div>

        <button type="button" class="btn btn-secondary" onclick="toggleLogs()">
            👁️ Voir les logs
        </button>
        
        <form action="{{ route('admin.maintenance.clear-logs') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer tous les logs ?')">
                🗑️ Purger logs
            </button>
        </form>
    </div>

    <!-- Backups -->
    <div class="maintenance-card">
        <h3>
            <span>💾</span>
            <span>Sauvegardes</span>
        </h3>
        <p>Créer des sauvegardes de la base de données et restaurer des versions précédentes.</p>
        
        <div style="margin-bottom: 15px;">
            <span class="status-indicator status-ok"></span>
            <strong>{{ count($backups) }} sauvegardes</strong>
        </div>

        <form action="{{ route('admin.maintenance.create-backup') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">
                💾 Créer backup
            </button>
        </form>
    </div>
</div>

<!-- Viewer des logs (masqué par défaut) -->
<div class="maintenance-card" id="logsViewer" style="display: none;">
    <h3>
        <span>📜</span>
        <span>Derniers logs système</span>
        <button type="button" onclick="toggleLogs()" class="btn btn-sm" style="margin-left: auto;">✕ Fermer</button>
    </h3>
    
    <div class="log-viewer" id="logContent">
        @forelse($recent_logs ?? [] as $log)
            <div class="log-line log-{{ $log['type'] }}">
                [{{ $log['timestamp'] }}] {{ $log['level'] }}: {{ $log['message'] }}
            </div>
        @empty
            <div class="log-line">Aucun log récent</div>
        @endforelse
    </div>
</div>

<!-- Liste des backups -->
@if(count($backups) > 0)
<div class="maintenance-card">
    <h3>
        <span>📦</span>
        <span>Liste des sauvegardes</span>
    </h3>
    
    <ul class="backup-list">
        @foreach($backups as $backup)
        <li class="backup-item">
            <div>
                <strong>{{ $backup['name'] }}</strong>
                <br>
                <small style="color: #7f8c8d;">
                    {{ $backup['date'] }} • {{ $backup['size'] }}
                </small>
            </div>
            <div style="display: flex; gap: 8px;">
                <form action="{{ route('admin.maintenance.download-backup', $backup['id']) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm">
                        ⬇️ Télécharger
                    </button>
                </form>
                <form action="{{ route('admin.maintenance.restore-backup', $backup['id']) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Restaurer cette sauvegarde ? L\'état actuel sera écrasé.')">
                        🔄 Restaurer
                    </button>
                </form>
                <form action="{{ route('admin.maintenance.delete-backup', $backup['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette sauvegarde ?')">
                        🗑️
                    </button>
                </form>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endif

<!-- Informations système -->
<div class="maintenance-card">
    <h3>
        <span>💻</span>
        <span>Informations Système</span>
    </h3>
    
    <table class="system-info-table">
        <tr>
            <td>Version PHP:</td>
            <td><strong>{{ $system_info['php_version'] ?? phpversion() }}</strong></td>
        </tr>
        <tr>
            <td>Version Laravel:</td>
            <td><strong>{{ $system_info['laravel_version'] ?? app()->version() }}</strong></td>
        </tr>
        <tr>
            <td>Environnement:</td>
            <td><strong>{{ $system_info['environment'] ?? config('app.env') }}</strong></td>
        </tr>
        <tr>
            <td>Mémoire utilisée:</td>
            <td><strong>{{ $system_info['memory_usage'] ?? '0 MB' }}</strong></td>
        </tr>
        <tr>
            <td>Espace disque:</td>
            <td>
                <strong>{{ $system_info['disk_free'] ?? '0 GB' }}</strong> / {{ $system_info['disk_total'] ?? '0 GB' }}
            </td>
        </tr>
        <tr>
            <td>Uptime serveur:</td>
            <td><strong>{{ $system_info['uptime'] ?? 'N/A' }}</strong></td>
        </tr>
    </table>
</div>

<!-- Mode Maintenance -->
<div class="maintenance-card" style="grid-column: 1 / -1;">
    <h3>
        <span>🚧</span>
        <span>Mode Maintenance</span>
    </h3>
    <p>Activer le mode maintenance pour effectuer des opérations critiques. Le site sera temporairement inaccessible aux utilisateurs.</p>
    
    @if($maintenance_mode ?? false)
        <div class="alert alert-warning">
            <span style="font-size: 20px;">⚠️</span>
            <span><strong>Mode maintenance activé</strong> - Le site est actuellement hors ligne pour les utilisateurs</span>
        </div>
        <form action="{{ route('admin.maintenance.disable') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">
                ✓ Désactiver mode maintenance
            </button>
        </form>
    @else
        <form action="{{ route('admin.maintenance.enable') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label for="maintenanceMessage" style="display: block; margin-bottom: 8px; font-weight: 600;">Message personnalisé:</label>
                <textarea name="message" id="maintenanceMessage" class="form-control" rows="3" placeholder="Message affiché aux utilisateurs...">Le site est actuellement en maintenance. Retour prévu sous peu.</textarea>
            </div>
            <button type="submit" class="btn btn-warning" onclick="return confirm('Activer le mode maintenance ? Le site sera inaccessible.')">
                🚧 Activer mode maintenance
            </button>
        </form>
    @endif
</div>

<script>
function toggleLogs() {
    const viewer = document.getElementById('logsViewer');
    viewer.style.display = viewer.style.display === 'none' ? 'block' : 'none';
}

function refreshCacheInfo() {
    location.reload();
}

// Auto-hide alerts
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 4000);
</script>
@endsection